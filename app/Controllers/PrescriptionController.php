<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PrescriptionController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get all prescriptions for display
     */
    public function index()
    {
        $builder = $this->db->table('prescriptions');
        $builder->orderBy('prescribed_date', 'DESC');
        $prescriptions = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $prescriptions
        ]);
    }

    /**
     * Create a new prescription
     */
    public function create()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'patient_id' => 'required|integer',
            'patient_name' => 'required|min_length[2]|max_length[200]',
            'medication_name' => 'required|min_length[2]|max_length[200]',
            'dosage' => 'required|min_length[2]|max_length[100]',
            'frequency' => 'permit_empty|max_length[100]',
            'duration' => 'permit_empty|max_length[100]',
            'priority' => 'permit_empty|in_list[low,medium,high,urgent]',
            'notes' => 'permit_empty|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate that the patient exists and is assigned to current doctor
        $patientId = $this->request->getPost('patient_id');
        $doctorId = session()->get('user_id') ?? 1;
        
        if (!$this->validatePatientAssignment($patientId, $doctorId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient not found or not assigned to you'
            ]);
        }

        $data = [
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => session()->get('user_id') ?? 1, // Get from session or default to 1
            'patient_name' => $this->request->getPost('patient_name'),
            'medication_name' => $this->request->getPost('medication_name'),
            'dosage' => $this->request->getPost('dosage'),
            'frequency' => $this->request->getPost('frequency') ?? '',
            'duration' => $this->request->getPost('duration') ?? '',
            'priority' => $this->request->getPost('priority') ?? 'medium',
            'status' => 'active',
            'notes' => $this->request->getPost('notes') ?? '',
            'prescribed_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $builder = $this->db->table('prescriptions');
        
        if ($builder->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Prescription created successfully',
                'data' => array_merge($data, ['id' => $this->db->insertID()])
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create prescription'
            ]);
        }
    }

    /**
     * Get a single prescription by ID
     */
    public function show($id)
    {
        $builder = $this->db->table('prescriptions');
        $prescription = $builder->where('id', $id)->get()->getRowArray();

        if (!$prescription) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $prescription
        ]);
    }

    /**
     * Update a prescription
     */
    public function update($id)
    {
        // Check if prescription exists
        $builder = $this->db->table('prescriptions');
        $existing = $builder->where('id', $id)->get()->getRowArray();
        
        if (!$existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found'
            ]);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'patient_id' => 'required|integer',
            'patient_name' => 'required|min_length[2]|max_length[200]',
            'medication_name' => 'required|min_length[2]|max_length[200]',
            'dosage' => 'required|min_length[2]|max_length[100]',
            'frequency' => 'permit_empty|max_length[100]',
            'duration' => 'permit_empty|max_length[100]',
            'priority' => 'permit_empty|in_list[low,medium,high,urgent]',
            'status' => 'permit_empty|in_list[active,completed,cancelled]',
            'notes' => 'permit_empty|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate that the patient exists and is assigned to current doctor
        $patientId = $this->request->getPost('patient_id');
        $doctorId = session()->get('user_id') ?? 1;
        
        if (!$this->validatePatientAssignment($patientId, $doctorId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient not found or not assigned to you'
            ]);
        }

        $data = [
            'patient_id' => $this->request->getPost('patient_id'),
            'patient_name' => $this->request->getPost('patient_name'),
            'medication_name' => $this->request->getPost('medication_name'),
            'dosage' => $this->request->getPost('dosage'),
            'frequency' => $this->request->getPost('frequency') ?? '',
            'duration' => $this->request->getPost('duration') ?? '',
            'priority' => $this->request->getPost('priority') ?? 'medium',
            'status' => $this->request->getPost('status') ?? 'active',
            'notes' => $this->request->getPost('notes') ?? '',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updated = $builder->where('id', $id)->update($data);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Prescription updated successfully',
                'data' => array_merge($data, ['id' => $id])
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update prescription'
            ]);
        }
    }

    /**
     * Update prescription status
     */
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['active', 'completed', 'cancelled'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid status'
            ]);
        }

        $builder = $this->db->table('prescriptions');
        $updated = $builder->where('id', $id)->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Prescription status updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update prescription status'
            ]);
        }
    }

    /**
     * Get prescriptions by patient ID
     */
    public function getByPatient($patientId)
    {
        $builder = $this->db->table('prescriptions');
        $builder->where('patient_id', $patientId);
        $builder->orderBy('prescribed_date', 'DESC');
        $prescriptions = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $prescriptions
        ]);
    }

    /**
     * Delete a prescription
     */
    public function delete($id)
    {
        // Check if prescription exists and belongs to current doctor
        $builder = $this->db->table('prescriptions');
        $prescription = $builder->where('id', $id)->get()->getRowArray();
        
        if (!$prescription) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found'
            ]);
        }

        // Verify doctor authorization (optional security check)
        $doctorId = session()->get('user_id') ?? 1;
        if ($prescription['doctor_id'] != $doctorId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized to delete this prescription'
            ]);
        }

        $deleted = $builder->where('id', $id)->delete();

        if ($deleted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Prescription deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete prescription'
            ]);
        }
    }

    /**
     * Get patients assigned to current doctor
     */
    public function getAssignedPatients()
    {
        $doctorId = session()->get('user_id') ?? 1;
        
        // For now, get all active patients since we don't have doctor-patient assignment table
        // In a real system, you'd join with a doctor_patient_assignments table
        $builder = $this->db->table('patients');
        $builder->select('id, first_name, last_name, status, room');
        $builder->where('status !=', 'Discharged');
        $builder->orderBy('first_name', 'ASC');
        $patients = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $patients
        ]);
    }

    /**
     * Validate that patient exists and is assigned to current doctor
     */
    private function validatePatientAssignment($patientId, $doctorId)
    {
        $builder = $this->db->table('patients');
        $patient = $builder->where('id', $patientId)->get()->getRowArray();
        
        if (!$patient) {
            return false; // Patient doesn't exist
        }
        
        // For now, allow all active patients since we don't have assignment table
        // In a real system, you'd check doctor_patient_assignments table
        if ($patient['status'] === 'Discharged') {
            return false; // Don't allow prescriptions for discharged patients
        }
        
        return true;
    }
}
