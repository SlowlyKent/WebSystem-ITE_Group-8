<?php

namespace App\Controllers;

use App\Models\PatientModel;
use App\Models\EmergencyContactModel;
use App\Models\ContactModel;
use App\Models\MedicalInfoModel;
use App\Models\InsuranceModel;
use CodeIgniter\Controller;

class PatientController extends Controller
{
    protected $patientModel;
    protected $emergencyContactModel;
    protected $contactModel;
    protected $medicalInfoModel;
    protected $insuranceModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->emergencyContactModel = new EmergencyContactModel();
        $this->contactModel = new ContactModel();
        $this->medicalInfoModel = new MedicalInfoModel();
        $this->insuranceModel = new InsuranceModel();
    }

    // Show all patients
    public function index()
    {
        try {
            $data['patients'] = $this->patientModel->findAll();
            
            // Debug: Log the number of patients found
            log_message('debug', 'Found ' . count($data['patients']) . ' patients');
            
            $content = view('dashboard/patient_list', $data, ['return' => true]);
            return view('dashboard/_layout', ['content' => $content]);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching patients: ' . $e->getMessage());
            $data['patients'] = [];
            $content = view('dashboard/patient_list', $data, ['return' => true]);
            return view('dashboard/_layout', ['content' => $content]);
        }
    }

    // Show patient details (view-only)
    public function view($id)
    {
        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }

        $data['patient'] = $patient;
        $content = view('dashboard/patient_view', $data, ['return' => true]);
        return view('dashboard/_layout', ['content' => $content]);
    }

    // Show add patient form
    public function create()
    {
        $content = view('dashboard/patient_form', [], ['return' => true]);
        return view('dashboard/_layout', ['content' => $content]);
    }

    // Save new patient
    public function store()
    {
        // Validate and save patient data
        $patientData = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
            'room' => $this->request->getPost('room'),
            'medical_notes' => $this->request->getPost('medical_notes'),
        ];

        // Debug: Log the data being inserted
        log_message('debug', 'Attempting to insert patient data: ' . json_encode($patientData));
        
        $patientId = $this->patientModel->insert($patientData);
        
        // Debug: Log the result
        if ($patientId) {
            log_message('debug', 'Patient inserted successfully with ID: ' . $patientId);
        } else {
            log_message('error', 'Failed to insert patient. Errors: ' . json_encode($this->patientModel->errors()));
        }

        if ($patientId) {
            // Only save related data if we have emergency contact info
            if ($this->request->getPost('emergency_name')) {
                $emergencyContactData = [
                    'patient_id' => $patientId,
                    'name' => $this->request->getPost('emergency_name'),
                    'relation' => $this->request->getPost('emergency_relation'),
                    'phone' => $this->request->getPost('emergency_phone'),
                ];
                $this->emergencyContactModel->insert($emergencyContactData);
            }

            // Save contact info if not already in patient table
            if ($this->request->getPost('phone') || $this->request->getPost('email') || $this->request->getPost('address')) {
                $contactData = [
                    'patient_id' => $patientId,
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'address' => $this->request->getPost('address'),
                ];
                $this->contactModel->insert($contactData);
            }

            // Save medical info if provided
            if ($this->request->getPost('blood_type') || $this->request->getPost('allergies')) {
                $medicalData = [
                    'patient_id' => $patientId,
                    'blood_type' => $this->request->getPost('blood_type'),
                    'allergies' => $this->request->getPost('allergies'),
                    'existing_condition' => $this->request->getPost('existing_condition'),
                    'primary_physician' => $this->request->getPost('primary_physician'),
                ];
                $this->medicalInfoModel->insert($medicalData);
            }

            // Save insurance info if provided
            if ($this->request->getPost('insurance_provider')) {
                $insuranceData = [
                    'patient_id' => $patientId,
                    'provider' => $this->request->getPost('insurance_provider'),
                    'policy' => $this->request->getPost('insurance_policy'),
                ];
                $this->insuranceModel->insert($insuranceData);
            }

            return redirect()->to(base_url('patients'))->with('success', 'Patient added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add patient')->withInput();
        }
    }

    // Show edit patient form
    public function edit($id)
    {
        $data['patient'] = $this->patientModel->find($id);
        $data['emergency_contact'] = $this->emergencyContactModel->where('patient_id', $id)->first();
        $data['contact'] = $this->contactModel->where('patient_id', $id)->first();
        $data['medical_info'] = $this->medicalInfoModel->where('patient_id', $id)->first();
        $data['insurance'] = $this->insuranceModel->where('patient_id', $id)->first();

        $content = view('dashboard/patient_form', $data, ['return' => true]);
        return view('dashboard/_layout', ['content' => $content]);
    }

    // Update patient
    public function update($id)
    {
        // Update patient data
        $patientData = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
            'room' => $this->request->getPost('room'),
            'medical_notes' => $this->request->getPost('medical_notes'),
        ];
        $this->patientModel->update($id, $patientData);

        // Update emergency contact if provided
        if ($this->request->getPost('emergency_name')) {
            $emergencyContactData = [
                'name' => $this->request->getPost('emergency_name'),
                'relation' => $this->request->getPost('emergency_relation'),
                'phone' => $this->request->getPost('emergency_phone'),
            ];
            
            // Check if emergency contact exists
            $existingEmergencyContact = $this->emergencyContactModel->where('patient_id', $id)->first();
            if ($existingEmergencyContact) {
                $this->emergencyContactModel->where('patient_id', $id)->set($emergencyContactData)->update();
            } else {
                $emergencyContactData['patient_id'] = $id;
                $this->emergencyContactModel->insert($emergencyContactData);
            }
        }

        // Update contact info if provided
        if ($this->request->getPost('phone') || $this->request->getPost('email') || $this->request->getPost('address')) {
            $contactData = [
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
            ];
            
            // Check if contact exists
            $existingContact = $this->contactModel->where('patient_id', $id)->first();
            if ($existingContact) {
                $this->contactModel->where('patient_id', $id)->set($contactData)->update();
            } else {
                $contactData['patient_id'] = $id;
                $this->contactModel->insert($contactData);
            }
        }

        // Update medical info if provided
        if ($this->request->getPost('blood_type') || $this->request->getPost('allergies')) {
            $medicalData = [
                'blood_type' => $this->request->getPost('blood_type'),
                'allergies' => $this->request->getPost('allergies'),
                'existing_condition' => $this->request->getPost('existing_condition'),
                'primary_physician' => $this->request->getPost('primary_physician'),
            ];
            
            // Check if medical info exists
            $existingMedical = $this->medicalInfoModel->where('patient_id', $id)->first();
            if ($existingMedical) {
                $this->medicalInfoModel->where('patient_id', $id)->set($medicalData)->update();
            } else {
                $medicalData['patient_id'] = $id;
                $this->medicalInfoModel->insert($medicalData);
            }
        }

        // Update insurance info if provided
        if ($this->request->getPost('insurance_provider')) {
            $insuranceData = [
                'provider' => $this->request->getPost('insurance_provider'),
                'policy' => $this->request->getPost('insurance_policy'),
            ];
            
            // Check if insurance exists
            $existingInsurance = $this->insuranceModel->where('patient_id', $id)->first();
            if ($existingInsurance) {
                $this->insuranceModel->where('patient_id', $id)->set($insuranceData)->update();
            } else {
                $insuranceData['patient_id'] = $id;
                $this->insuranceModel->insert($insuranceData);
            }
        }

        return redirect()->to(base_url('patients'))->with('success', 'Patient updated successfully');
    }

    // Delete patient
    public function delete($id)
    {
        $this->patientModel->delete($id);
        $this->emergencyContactModel->where('patient_id', $id)->delete();
        $this->contactModel->where('patient_id', $id)->delete();
        $this->medicalInfoModel->where('patient_id', $id)->delete();
        $this->insuranceModel->where('patient_id', $id)->delete();

        return redirect()->to('/patients')->with('success', 'Patient deleted successfully');
    }
}
