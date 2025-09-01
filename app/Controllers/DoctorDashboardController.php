<?php

namespace App\Controllers;

class DoctorDashboardController extends BaseController
{
    public function index()
    {
        return view('doctor/dashboard');
    }

    public function patientEhr()
    {
        return view('doctor/PatientEHR');
    }

    public function mySchedule()
    {
        return view('doctor/MySchedule');
    }

    public function labResults()
    {
        // Create lab_requests table if it doesn't exist
        $this->createLabRequestsTable();
        
        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Get lab requests for the current doctor
        $labRequests = $this->getLabRequestsByDoctor($doctorId);
        
        // Get existing patients for the dropdown
        $patients = $this->getActivePatients();
        
        // Get lab staff for assignment
        $labStaff = $this->getLabStaff();
        
        $data = [
            'labRequests' => $labRequests,
            'patients' => $patients,
            'labStaff' => $labStaff,
            'title' => 'Lab Results Management'
        ];
        
        return view('doctor/LabResults', $data);
    }

    public function createLabRequest()
    {
        // Validate request
        $rules = [
            'patient_id' => 'required|integer',
            'lab_staff_id' => 'required|integer',
            'test_type' => 'required|min_length[2]|max_length[255]',
            'test_description' => 'required|min_length[5]|max_length[1000]',
            'priority' => 'required|in_list[low,normal,high,urgent]',
            'requested_date' => 'required|valid_date',
            'expected_completion_date' => 'permit_empty|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Generate lab request ID
        $requestId = $this->generateLabRequestId();
        
        // Prepare lab request data
        $labRequestData = [
            'request_id' => $requestId,
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $doctorId,
            'lab_staff_id' => $this->request->getPost('lab_staff_id'),
            'test_type' => $this->request->getPost('test_type'),
            'test_description' => $this->request->getPost('test_description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'pending',
            'requested_date' => $this->request->getPost('requested_date'),
            'expected_completion_date' => $this->request->getPost('expected_completion_date') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Insert lab request directly to database
            $db = \Config\Database::connect();
            $builder = $db->table('lab_requests');
            $inserted = $builder->insert($labRequestData);
            
            if ($inserted) {
                // Get the created lab request with details
                $labRequest = $this->getLabRequestWithDetails($db->insertID());
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lab request created successfully',
                    'labRequest' => $labRequest
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create lab request'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error creating lab request: ' . $e->getMessage()
            ]);
        }
    }

    public function getLabRequestDetails($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request ID is required'
            ]);
        }

        // Check if lab request exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        $labRequest = $builder->where('id', $id)
                             ->where('doctor_id', $doctorId)
                             ->get()
                             ->getRowArray();

        if (!$labRequest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request not found or access denied'
            ]);
        }

        // Get lab request with full details including results if completed
        $labRequestDetails = $this->getLabRequestWithDetails($id);

        return $this->response->setJSON([
            'success' => true,
            'labRequest' => $labRequestDetails
        ]);
    }

    public function updateLabRequest($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request ID is required'
            ]);
        }

        // Validate request
        $rules = [
            'test_type' => 'required|min_length[2]|max_length[255]',
            'test_description' => 'required|min_length[5]|max_length[1000]',
            'priority' => 'required|in_list[low,normal,high,urgent]',
            'expected_completion_date' => 'permit_empty|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Check if lab request exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        $labRequest = $builder->where('id', $id)
                             ->where('doctor_id', $doctorId)
                             ->get()
                             ->getRowArray();

        if (!$labRequest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request not found or access denied'
            ]);
        }

        // Only allow updates if status is pending or in_progress
        if (!in_array($labRequest['status'], ['pending', 'in_progress'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot update lab request with status: ' . $labRequest['status']
            ]);
        }

        // Prepare update data
        $updateData = [
            'test_type' => $this->request->getPost('test_type'),
            'test_description' => $this->request->getPost('test_description'),
            'priority' => $this->request->getPost('priority'),
            'expected_completion_date' => $this->request->getPost('expected_completion_date') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Update lab request
            $updated = $builder->where('id', $id)->update($updateData);
            
            if ($updated) {
                // Get the updated lab request with details
                $labRequest = $this->getLabRequestWithDetails($id);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lab request updated successfully',
                    'labRequest' => $labRequest
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update lab request'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating lab request: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteLabRequest($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request ID is required'
            ]);
        }

        // Check if lab request exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        $labRequest = $builder->where('id', $id)
                             ->where('doctor_id', $doctorId)
                             ->get()
                             ->getRowArray();

        if (!$labRequest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lab request not found or access denied'
            ]);
        }

        // Only allow deletion if status is pending
        if ($labRequest['status'] !== 'pending') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot delete lab request with status: ' . $labRequest['status']
            ]);
        }

        try {
            // Delete lab request
            $deleted = $builder->where('id', $id)->delete();
            
            if ($deleted) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Lab request deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete lab request'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting lab request: ' . $e->getMessage()
            ]);
        }
    }

    public function searchLabRequests()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (!$searchTerm) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Search term is required'
            ]);
        }

        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Search lab requests directly from database
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        $builder->select('lab_requests.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, users.first_name as lab_staff_first_name, users.last_name as lab_staff_last_name');
        $builder->join('patients', 'patients.id = lab_requests.patient_id');
        $builder->join('users', 'users.id = lab_requests.lab_staff_id');
        $builder->groupStart();
        $builder->like('patients.first_name', $searchTerm);
        $builder->orLike('patients.last_name', $searchTerm);
        $builder->orLike('patients.patient_id', $searchTerm);
        $builder->orLike('lab_requests.test_type', $searchTerm);
        $builder->orLike('lab_requests.request_id', $searchTerm);
        $builder->groupEnd();
        $builder->where('lab_requests.doctor_id', $doctorId);
        
        $labRequests = $builder->orderBy('lab_requests.requested_date', 'DESC')->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'labRequests' => $labRequests
        ]);
    }

    public function prescriptions()
    {
        // Create prescriptions table if it doesn't exist
        $this->createPrescriptionsTable();
        
        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Get prescriptions for the current doctor
        $prescriptions = $this->getPrescriptionsByDoctor($doctorId);
        
        // Get existing patients for the dropdown
        $patients = $this->getActivePatients();
        
        $data = [
            'prescriptions' => $prescriptions,
            'patients' => $patients,
            'title' => 'Prescription Management'
        ];
        
        return view('doctor/Prescription', $data);
    }

    public function createPrescription()
    {
        // Validate request
        $rules = [
            'patient_id' => 'required|integer',
            'medication' => 'required|min_length[2]|max_length[255]',
            'dosage' => 'required|min_length[2]|max_length[100]',
            'frequency' => 'required|in_list[once_daily,twice_daily,three_times,four_times,as_needed,every_4_hours,every_6_hours,every_8_hours,every_12_hours]',
            'duration' => 'required|min_length[2]|max_length[100]',
            'instructions' => 'permit_empty|max_length[1000]',
            'prescribed_date' => 'required|valid_date',
            'expiry_date' => 'permit_empty|valid_date',
            'refills_remaining' => 'permit_empty|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Generate prescription ID
        $prescriptionId = $this->generatePrescriptionId();
        
        // Prepare prescription data
        $prescriptionData = [
            'prescription_id' => $prescriptionId,
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $doctorId,
            'medication' => $this->request->getPost('medication'),
            'dosage' => $this->request->getPost('dosage'),
            'frequency' => $this->request->getPost('frequency'),
            'duration' => $this->request->getPost('duration'),
            'instructions' => $this->request->getPost('instructions'),
            'status' => 'active',
            'prescribed_date' => $this->request->getPost('prescribed_date'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'refills_remaining' => $this->request->getPost('refills_remaining') ?: 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Insert prescription directly to database
            $db = \Config\Database::connect();
            $builder = $db->table('prescriptions');
            $inserted = $builder->insert($prescriptionData);
            
            if ($inserted) {
                // Get the created prescription with details
                $prescription = $this->getPrescriptionWithDetails($db->insertID());
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Prescription created successfully',
                    'prescription' => $prescription
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create prescription'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error creating prescription: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePrescription($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription ID is required'
            ]);
        }

        // Validate request
        $rules = [
            'medication' => 'required|min_length[2]|max_length[255]',
            'dosage' => 'required|min_length[2]|max_length[100]',
            'frequency' => 'required|in_list[once_daily,twice_daily,three_times,four_times,as_needed,every_4_hours,every_6_hours,every_8_hours,every_12_hours]',
            'duration' => 'required|min_length[2]|max_length[100]',
            'instructions' => 'permit_empty|max_length[1000]',
            'status' => 'required|in_list[active,completed,cancelled,expired]',
            'prescribed_date' => 'required|valid_date',
            'expiry_date' => 'permit_empty|valid_date',
            'refills_remaining' => 'permit_empty|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Check if prescription exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        $prescription = $builder->where('id', $id)
                               ->where('doctor_id', $doctorId)
                               ->get()
                               ->getRowArray();

        if (!$prescription) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found or access denied'
            ]);
        }

        // Prepare update data
        $updateData = [
            'medication' => $this->request->getPost('medication'),
            'dosage' => $this->request->getPost('dosage'),
            'frequency' => $this->request->getPost('frequency'),
            'duration' => $this->request->getPost('duration'),
            'instructions' => $this->request->getPost('instructions'),
            'status' => $this->request->getPost('status'),
            'prescribed_date' => $this->request->getPost('prescribed_date'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'refills_remaining' => $this->request->getPost('refills_remaining') ?: 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Update prescription
            $updated = $builder->where('id', $id)->update($updateData);
            
            if ($updated) {
                // Get the updated prescription with details
                $prescription = $this->getPrescriptionWithDetails($id);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Prescription updated successfully',
                    'prescription' => $prescription
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update prescription'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating prescription: ' . $e->getMessage()
            ]);
        }
    }

    public function deletePrescription($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription ID is required'
            ]);
        }

        // Check if prescription exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        $prescription = $builder->where('id', $id)
                               ->where('doctor_id', $doctorId)
                               ->get()
                               ->getRowArray();

        if (!$prescription) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found or access denied'
            ]);
        }

        try {
            // Delete prescription
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
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting prescription: ' . $e->getMessage()
            ]);
        }
    }

    public function getPrescription($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription ID is required'
            ]);
        }

        // Check if prescription exists and belongs to current doctor
        $doctorId = session()->get('user_id');
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        $prescription = $builder->where('id', $id)
                               ->where('doctor_id', $doctorId)
                               ->get()
                               ->getRowArray();

        if (!$prescription) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found or access denied'
            ]);
        }

        // Get prescription with full details
        $prescriptionDetails = $this->getPrescriptionWithDetails($id);

        return $this->response->setJSON([
            'success' => true,
            'prescription' => $prescriptionDetails
        ]);
    }

    public function searchPrescriptions()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (!$searchTerm) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Search term is required'
            ]);
        }

        // Get current doctor's ID from session
        $doctorId = session()->get('user_id');
        
        // Search prescriptions directly from database
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        $builder->select('prescriptions.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id');
        $builder->join('patients', 'patients.id = prescriptions.patient_id');
        $builder->groupStart();
        $builder->like('patients.first_name', $searchTerm);
        $builder->orLike('patients.last_name', $searchTerm);
        $builder->orLike('patients.patient_id', $searchTerm);
        $builder->orLike('prescriptions.medication', $searchTerm);
        $builder->groupEnd();
        $builder->where('prescriptions.doctor_id', $doctorId);
        
        $prescriptions = $builder->orderBy('prescriptions.prescribed_date', 'DESC')->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'prescriptions' => $prescriptions
        ]);
    }

    // Helper method to create prescriptions table
    private function createPrescriptionsTable()
    {
        $db = \Config\Database::connect();
        
        // Check if table exists
        if ($db->tableExists('prescriptions')) {
            return;
        }

        // Create table structure
        $sql = "CREATE TABLE `prescriptions` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `prescription_id` varchar(20) NOT NULL,
            `patient_id` int(11) unsigned NOT NULL,
            `doctor_id` int(11) unsigned NOT NULL,
            `medication` varchar(255) NOT NULL,
            `dosage` varchar(100) NOT NULL,
            `frequency` enum('once_daily','twice_daily','three_times','four_times','as_needed','every_4_hours','every_6_hours','every_8_hours','every_12_hours') NOT NULL,
            `duration` varchar(100) NOT NULL,
            `instructions` text,
            `status` enum('active','completed','cancelled','expired') NOT NULL DEFAULT 'active',
            `prescribed_date` date NOT NULL,
            `expiry_date` date DEFAULT NULL,
            `refills_remaining` int(3) DEFAULT '0',
            `pharmacy_notes` text,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_prescription_id` (`prescription_id`),
            KEY `idx_patient_id` (`patient_id`),
            KEY `idx_doctor_id` (`doctor_id`),
            KEY `idx_status` (`status`),
            KEY `idx_prescribed_date` (`prescribed_date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $db->query($sql);
    }

    // Helper method to generate unique prescription ID
    private function generatePrescriptionId()
    {
        $prefix = 'RX';
        $year = date('Y');
        $month = date('m');
        
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        
        // Get the last prescription ID for this month
        $lastPrescription = $builder->where('prescription_id LIKE', "{$prefix}{$year}{$month}%")
                                   ->orderBy('prescription_id', 'DESC')
                                   ->get()
                                   ->getRowArray();
        
        if ($lastPrescription) {
            $lastNumber = (int) substr($lastPrescription['prescription_id'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Helper method to get prescription with patient and doctor details
    private function getPrescriptionWithDetails($prescriptionId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        return $builder->select('prescriptions.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, patients.date_of_birth, patients.gender, users.first_name as doctor_first_name, users.last_name as doctor_last_name')
                      ->join('patients', 'patients.id = prescriptions.patient_id')
                      ->join('users', 'users.id = prescriptions.doctor_id')
                      ->where('prescriptions.id', $prescriptionId)
                      ->get()
                      ->getRowArray();
    }

    // Helper method to get prescriptions by doctor
    private function getPrescriptionsByDoctor($doctorId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('prescriptions');
        $builder->select('prescriptions.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id');
        $builder->join('patients', 'patients.id = prescriptions.patient_id');
        $builder->where('prescriptions.doctor_id', $doctorId);
        
        return $builder->orderBy('prescriptions.prescribed_date', 'DESC')->get()->getResultArray();
    }

    // Helper method to get active patients
    private function getActivePatients()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('patients');
        return $builder->select('id, patient_id, first_name, last_name')
                      ->where('status', 'active')
                      ->get()
                      ->getResultArray();
    }

    // Helper method to create lab_requests table
    private function createLabRequestsTable()
    {
        $db = \Config\Database::connect();
        
        // Check if table exists
        if ($db->tableExists('lab_requests')) {
            return;
        }

        // Create table structure
        $sql = "CREATE TABLE `lab_requests` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `request_id` varchar(20) NOT NULL,
            `patient_id` int(11) unsigned NOT NULL,
            `doctor_id` int(11) unsigned NOT NULL,
            `lab_staff_id` int(11) unsigned NOT NULL,
            `test_type` varchar(255) NOT NULL,
            `test_description` text NOT NULL,
            `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
            `status` enum('pending','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
            `requested_date` date NOT NULL,
            `expected_completion_date` date DEFAULT NULL,
            `actual_completion_date` date DEFAULT NULL,
            `lab_results` text DEFAULT NULL,
            `lab_notes` text DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_request_id` (`request_id`),
            KEY `idx_patient_id` (`patient_id`),
            KEY `idx_doctor_id` (`doctor_id`),
            KEY `idx_lab_staff_id` (`lab_staff_id`),
            KEY `idx_status` (`status`),
            KEY `idx_requested_date` (`requested_date`),
            KEY `idx_priority` (`priority`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $db->query($sql);
    }

    // Helper method to generate unique lab request ID
    private function generateLabRequestId()
    {
        $prefix = 'LAB';
        $year = date('Y');
        $month = date('m');
        
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        
        // Get the last lab request ID for this month
        $lastRequest = $builder->where('request_id LIKE', "{$prefix}{$year}{$month}%")
                               ->orderBy('request_id', 'DESC')
                               ->get()
                               ->getRowArray();
        
        if ($lastRequest) {
            $lastNumber = (int) substr($lastRequest['request_id'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Helper method to get lab request with patient, doctor, and lab staff details
    private function getLabRequestWithDetails($requestId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        return $builder->select('lab_requests.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, patients.date_of_birth, patients.gender, 
                                users.first_name as doctor_first_name, users.last_name as doctor_last_name,
                                lab_users.first_name as lab_staff_first_name, lab_users.last_name as lab_staff_last_name')
                      ->join('patients', 'patients.id = lab_requests.patient_id')
                      ->join('users', 'users.id = lab_requests.doctor_id')
                      ->join('users as lab_users', 'lab_users.id = lab_requests.lab_staff_id')
                      ->where('lab_requests.id', $requestId)
                      ->get()
                      ->getRowArray();
    }

    // Helper method to get lab requests by doctor
    private function getLabRequestsByDoctor($doctorId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lab_requests');
        $builder->select('lab_requests.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, 
                         users.first_name as lab_staff_first_name, users.last_name as lab_staff_last_name');
        $builder->join('patients', 'patients.id = lab_requests.patient_id');
        $builder->join('users', 'users.id = lab_requests.lab_staff_id');
        $builder->where('lab_requests.doctor_id', $doctorId);
        
        return $builder->orderBy('lab_requests.requested_date', 'DESC')->get()->getResultArray();
    }

    // Helper method to get lab staff
    private function getLabStaff()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        return $builder->select('id, first_name, last_name, username')
                      ->where('role', 'lab_staff')
                      ->where('status', 'active')
                      ->get()
                      ->getResultArray();
    }

    // ===== PATIENT MANAGEMENT METHODS =====
    
    public function getPatients()
    {
        $doctorId = session()->get('user_id');
        
        $db = \Config\Database::connect();
        $builder = $db->table('patients');
        $builder->select('patients.*, contacts.phone, contacts.email, medical_info.blood_type, medical_info.allergies');
        $builder->join('contacts', 'contacts.patient_id = patients.id', 'left');
        $builder->join('medical_info', 'medical_info.patient_id = patients.id', 'left');
        $builder->where('patients.status', 'active');
        
        $patients = $builder->orderBy('patients.last_name', 'ASC')->get()->getResultArray();
        
        return $this->response->setJSON([
            'success' => true,
            'patients' => $patients
        ]);
    }
    
    public function getPatientDetails($patientId = null)
    {
        if (!$patientId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient ID is required'
            ]);
        }
        
        $db = \Config\Database::connect();
        
        // Get patient with all related information
        $builder = $db->table('patients');
        $patient = $builder->select('patients.*, contacts.phone, contacts.email, contacts.address, contacts.city, contacts.state, contacts.zip_code,
                                    emergency_contacts.name as emergency_name, emergency_contacts.relationship, emergency_contacts.phone as emergency_phone,
                                    medical_info.blood_type, medical_info.allergies, medical_info.medical_history, medical_info.current_medications,
                                    insurance.provider, insurance.policy_number, insurance.group_number')
                          ->join('contacts', 'contacts.patient_id = patients.id', 'left')
                          ->join('emergency_contacts', 'emergency_contacts.patient_id = patients.id', 'left')
                          ->join('medical_info', 'medical_info.patient_id = patients.id', 'left')
                          ->join('insurance', 'insurance.patient_id = patients.id', 'left')
                          ->where('patients.id', $patientId)
                          ->get()
                          ->getRowArray();
        
        if (!$patient) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient not found'
            ]);
        }
        
        // Get patient's recent prescriptions
        $prescriptionsBuilder = $db->table('prescriptions');
        $prescriptions = $prescriptionsBuilder->where('patient_id', $patientId)
                                             ->where('doctor_id', session()->get('user_id'))
                                             ->orderBy('prescribed_date', 'DESC')
                                             ->limit(5)
                                             ->get()
                                             ->getResultArray();
        
        // Get patient's recent lab requests
        $labBuilder = $db->table('lab_requests');
        $labRequests = $labBuilder->where('patient_id', $patientId)
                                 ->where('doctor_id', session()->get('user_id'))
                                 ->orderBy('requested_date', 'DESC')
                                 ->limit(5)
                                 ->get()
                                 ->getResultArray();
        
        return $this->response->setJSON([
            'success' => true,
            'patient' => $patient,
            'recent_prescriptions' => $prescriptions,
            'recent_lab_requests' => $labRequests
        ]);
    }
    
    // ===== APPOINTMENT MANAGEMENT METHODS =====
    
    public function getAppointments()
    {
        $this->createAppointmentsTable();
        
        $doctorId = session()->get('user_id');
        $date = $this->request->getGet('date') ?: date('Y-m-d');
        
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        $builder->select('appointments.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id');
        $builder->join('patients', 'patients.id = appointments.patient_id');
        $builder->where('appointments.doctor_id', $doctorId);
        $builder->where('DATE(appointments.appointment_date)', $date);
        
        $appointments = $builder->orderBy('appointments.appointment_time', 'ASC')->get()->getResultArray();
        
        return $this->response->setJSON([
            'success' => true,
            'appointments' => $appointments,
            'date' => $date
        ]);
    }
    
    public function createAppointment()
    {
        $rules = [
            'patient_id' => 'required|integer',
            'appointment_date' => 'required|valid_date',
            'appointment_time' => 'required',
            'duration' => 'required|integer|greater_than[0]',
            'appointment_type' => 'required|in_list[consultation,follow_up,emergency,routine_checkup,specialist_referral]',
            'reason' => 'required|min_length[5]|max_length[500]',
            'notes' => 'permit_empty|max_length[1000]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $doctorId = session()->get('user_id');
        $appointmentDateTime = $this->request->getPost('appointment_date') . ' ' . $this->request->getPost('appointment_time');
        
        // Check for scheduling conflicts
        $conflict = $this->checkAppointmentConflict($doctorId, $appointmentDateTime, $this->request->getPost('duration'));
        if ($conflict) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment time conflicts with existing appointment'
            ]);
        }
        
        $appointmentData = [
            'appointment_id' => $this->generateAppointmentId(),
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $doctorId,
            'appointment_date' => $this->request->getPost('appointment_date'),
            'appointment_time' => $this->request->getPost('appointment_time'),
            'duration' => $this->request->getPost('duration'),
            'appointment_type' => $this->request->getPost('appointment_type'),
            'reason' => $this->request->getPost('reason'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'scheduled',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('appointments');
            $inserted = $builder->insert($appointmentData);
            
            if ($inserted) {
                $appointment = $this->getAppointmentWithDetails($db->insertID());
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Appointment created successfully',
                    'appointment' => $appointment
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create appointment'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error creating appointment: ' . $e->getMessage()
            ]);
        }
    }
    
    public function updateAppointment($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment ID is required'
            ]);
        }
        
        $rules = [
            'appointment_date' => 'required|valid_date',
            'appointment_time' => 'required',
            'duration' => 'required|integer|greater_than[0]',
            'appointment_type' => 'required|in_list[consultation,follow_up,emergency,routine_checkup,specialist_referral]',
            'reason' => 'required|min_length[5]|max_length[500]',
            'status' => 'required|in_list[scheduled,confirmed,in_progress,completed,cancelled,no_show]',
            'notes' => 'permit_empty|max_length[1000]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $doctorId = session()->get('user_id');
        
        // Check if appointment exists and belongs to doctor
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        $appointment = $builder->where('id', $id)
                              ->where('doctor_id', $doctorId)
                              ->get()
                              ->getRowArray();
        
        if (!$appointment) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment not found or access denied'
            ]);
        }
        
        $appointmentDateTime = $this->request->getPost('appointment_date') . ' ' . $this->request->getPost('appointment_time');
        
        // Check for scheduling conflicts (excluding current appointment)
        $conflict = $this->checkAppointmentConflict($doctorId, $appointmentDateTime, $this->request->getPost('duration'), $id);
        if ($conflict) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment time conflicts with existing appointment'
            ]);
        }
        
        $updateData = [
            'appointment_date' => $this->request->getPost('appointment_date'),
            'appointment_time' => $this->request->getPost('appointment_time'),
            'duration' => $this->request->getPost('duration'),
            'appointment_type' => $this->request->getPost('appointment_type'),
            'reason' => $this->request->getPost('reason'),
            'status' => $this->request->getPost('status'),
            'notes' => $this->request->getPost('notes'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $updated = $builder->where('id', $id)->update($updateData);
            
            if ($updated) {
                $appointment = $this->getAppointmentWithDetails($id);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Appointment updated successfully',
                    'appointment' => $appointment
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update appointment'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error updating appointment: ' . $e->getMessage()
            ]);
        }
    }
    
    public function deleteAppointment($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment ID is required'
            ]);
        }
        
        $doctorId = session()->get('user_id');
        
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        $appointment = $builder->where('id', $id)
                              ->where('doctor_id', $doctorId)
                              ->get()
                              ->getRowArray();
        
        if (!$appointment) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Appointment not found or access denied'
            ]);
        }
        
        // Only allow deletion if appointment is not completed
        if ($appointment['status'] === 'completed') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot delete completed appointment'
            ]);
        }
        
        try {
            $deleted = $builder->where('id', $id)->delete();
            
            if ($deleted) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Appointment deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to delete appointment'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error deleting appointment: ' . $e->getMessage()
            ]);
        }
    }
    
    // ===== MEDICAL RECORDS METHODS =====
    
    public function addMedicalNote()
    {
        $this->createMedicalNotesTable();
        
        $rules = [
            'patient_id' => 'required|integer',
            'note_type' => 'required|in_list[consultation,diagnosis,treatment,follow_up,referral,general]',
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]|max_length[5000]',
            'is_confidential' => 'permit_empty|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $doctorId = session()->get('user_id');
        
        $noteData = [
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $doctorId,
            'note_type' => $this->request->getPost('note_type'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'is_confidential' => $this->request->getPost('is_confidential') ?: 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('medical_notes');
            $inserted = $builder->insert($noteData);
            
            if ($inserted) {
                $note = $this->getMedicalNoteWithDetails($db->insertID());
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Medical note added successfully',
                    'note' => $note
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add medical note'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error adding medical note: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getPatientMedicalNotes($patientId = null)
    {
        if (!$patientId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient ID is required'
            ]);
        }
        
        $doctorId = session()->get('user_id');
        
        $db = \Config\Database::connect();
        $builder = $db->table('medical_notes');
        $builder->select('medical_notes.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name');
        $builder->join('users', 'users.id = medical_notes.doctor_id');
        $builder->where('medical_notes.patient_id', $patientId);
        $builder->where('medical_notes.doctor_id', $doctorId);
        
        $notes = $builder->orderBy('medical_notes.created_at', 'DESC')->get()->getResultArray();
        
        return $this->response->setJSON([
            'success' => true,
            'notes' => $notes
        ]);
    }
    
    // ===== DASHBOARD ANALYTICS METHODS =====
    
    public function getDashboardStats()
    {
        $doctorId = session()->get('user_id');
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        
        $db = \Config\Database::connect();
        
        // Today's appointments
        $todayAppointments = $db->table('appointments')
                               ->where('doctor_id', $doctorId)
                               ->where('DATE(appointment_date)', $today)
                               ->countAllResults();
        
        // This month's patients
        $monthlyPatients = $db->table('appointments')
                             ->select('DISTINCT patient_id')
                             ->where('doctor_id', $doctorId)
                             ->where('DATE_FORMAT(appointment_date, "%Y-%m")', $thisMonth)
                             ->countAllResults();
        
        // Pending prescriptions
        $pendingPrescriptions = $db->table('prescriptions')
                                  ->where('doctor_id', $doctorId)
                                  ->where('status', 'active')
                                  ->countAllResults();
        
        // Pending lab requests
        $pendingLabRequests = $db->table('lab_requests')
                                ->where('doctor_id', $doctorId)
                                ->whereIn('status', ['pending', 'in_progress'])
                                ->countAllResults();
        
        return $this->response->setJSON([
            'success' => true,
            'stats' => [
                'today_appointments' => $todayAppointments,
                'monthly_patients' => $monthlyPatients,
                'pending_prescriptions' => $pendingPrescriptions,
                'pending_lab_requests' => $pendingLabRequests
            ]
        ]);
    }
    
    // ===== HELPER METHODS =====
    
    private function createAppointmentsTable()
    {
        $db = \Config\Database::connect();
        
        if ($db->tableExists('appointments')) {
            return;
        }
        
        $sql = "CREATE TABLE `appointments` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `appointment_id` varchar(20) NOT NULL,
            `patient_id` int(11) unsigned NOT NULL,
            `doctor_id` int(11) unsigned NOT NULL,
            `appointment_date` date NOT NULL,
            `appointment_time` time NOT NULL,
            `duration` int(3) NOT NULL DEFAULT '30',
            `appointment_type` enum('consultation','follow_up','emergency','routine_checkup','specialist_referral') NOT NULL,
            `reason` varchar(500) NOT NULL,
            `notes` text,
            `status` enum('scheduled','confirmed','in_progress','completed','cancelled','no_show') NOT NULL DEFAULT 'scheduled',
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_appointment_id` (`appointment_id`),
            KEY `idx_patient_id` (`patient_id`),
            KEY `idx_doctor_id` (`doctor_id`),
            KEY `idx_appointment_date` (`appointment_date`),
            KEY `idx_status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        $db->query($sql);
    }
    
    private function createMedicalNotesTable()
    {
        $db = \Config\Database::connect();
        
        if ($db->tableExists('medical_notes')) {
            return;
        }
        
        $sql = "CREATE TABLE `medical_notes` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `patient_id` int(11) unsigned NOT NULL,
            `doctor_id` int(11) unsigned NOT NULL,
            `note_type` enum('consultation','diagnosis','treatment','follow_up','referral','general') NOT NULL,
            `title` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `is_confidential` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_patient_id` (`patient_id`),
            KEY `idx_doctor_id` (`doctor_id`),
            KEY `idx_note_type` (`note_type`),
            KEY `idx_created_at` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        $db->query($sql);
    }
    
    private function generateAppointmentId()
    {
        $prefix = 'APT';
        $year = date('Y');
        $month = date('m');
        
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        
        $lastAppointment = $builder->where('appointment_id LIKE', "{$prefix}{$year}{$month}%")
                                  ->orderBy('appointment_id', 'DESC')
                                  ->get()
                                  ->getRowArray();
        
        if ($lastAppointment) {
            $lastNumber = (int) substr($lastAppointment['appointment_id'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
    
    private function checkAppointmentConflict($doctorId, $appointmentDateTime, $duration, $excludeId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        
        $startTime = $appointmentDateTime;
        $endTime = date('Y-m-d H:i:s', strtotime($appointmentDateTime . ' + ' . $duration . ' minutes'));
        
        $builder->where('doctor_id', $doctorId);
        $builder->where('status !=', 'cancelled');
        $builder->groupStart();
        $builder->where('CONCAT(appointment_date, " ", appointment_time) <', $endTime);
        $builder->where('DATE_ADD(CONCAT(appointment_date, " ", appointment_time), INTERVAL duration MINUTE) >', $startTime);
        $builder->groupEnd();
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }
    
    private function getAppointmentWithDetails($appointmentId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('appointments');
        return $builder->select('appointments.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, patients.date_of_birth, patients.gender')
                      ->join('patients', 'patients.id = appointments.patient_id')
                      ->where('appointments.id', $appointmentId)
                      ->get()
                      ->getRowArray();
    }
    
    private function getMedicalNoteWithDetails($noteId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('medical_notes');
        return $builder->select('medical_notes.*, patients.first_name, patients.last_name, patients.patient_id as patient_unique_id, users.first_name as doctor_first_name, users.last_name as doctor_last_name')
                      ->join('patients', 'patients.id = medical_notes.patient_id')
                      ->join('users', 'users.id = medical_notes.doctor_id')
                      ->where('medical_notes.id', $noteId)
                      ->get()
                      ->getRowArray();
    }
}
