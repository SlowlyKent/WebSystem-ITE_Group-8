<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Models\UserModel;
use App\Models\PatientModel;
use CodeIgniter\Controller;

class SchedulingController extends BaseController
{
    protected $scheduleModel;
    protected $userModel;
    protected $patientModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->userModel = new UserModel();
        $this->patientModel = new PatientModel();
        helper(['url', 'form']);
    }

    /**
     * Display the main scheduling page
     */
    public function index()
    {
        // Check if user is authenticated
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Check if user has permission to access scheduling
        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'doctor', 'nurse'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        // Get all schedules with details
        $schedules = $this->scheduleModel->getAllSchedulesWithDetails();
        
        // Get all doctors for the dropdown
        $doctors = $this->userModel->getUsersByRole('doctor');
        
        // Get all patients for the dropdown
        $patients = $this->patientModel->findAll();

        $data = [
            'title' => 'Doctor Scheduling',
            'currentPage' => 'scheduling',
            'schedules' => $schedules,
            'doctors' => $doctors,
            'patients' => $patients
        ];

        return view('role_dashboard/admin/Scheduling/doctorShed', $data);
    }

    /**
     * Get schedules as JSON for AJAX requests
     */
    public function getSchedules()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $startDate = $this->request->getGet('start');
        $endDate = $this->request->getGet('end');
        $doctorId = $this->request->getGet('doctor_id');

        $schedules = $this->scheduleModel->getSchedulesForCalendar($startDate, $endDate, $doctorId);
        
        // Format schedules for calendar
        $events = [];
        foreach ($schedules as $schedule) {
            $events[] = [
                'id' => $schedule['id'],
                'title' => $schedule['title'],
                'start' => $schedule['schedule_date'] . 'T' . $schedule['start_time'],
                'end' => $schedule['schedule_date'] . 'T' . $schedule['end_time'],
                'description' => $schedule['description'],
                'doctor' => $schedule['doctor_first_name'] . ' ' . $schedule['doctor_last_name'],
                'patient' => $schedule['patient_first_name'] ? $schedule['patient_first_name'] . ' ' . $schedule['patient_last_name'] : null,
                'type' => $schedule['schedule_type'],
                'status' => $schedule['status'],
                'location' => $schedule['location']
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Add a new schedule entry
     */
    public function add()
    {
        // Check authentication and permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        // Handle form submission for adding schedule
        if ($this->request->getMethod() === 'POST') {
            // Get the current user ID from session
            $createdBy = session()->get('userId');
            
            $data = [
                'doctor_id' => $this->request->getPost('doctor_id'),
                'title' => $this->request->getPost('description'), // Use description as title
                'description' => $this->request->getPost('description'),
                'schedule_date' => $this->request->getPost('schedule_date'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'schedule_type' => $this->request->getPost('schedule_type'),
                'location' => $this->request->getPost('location'),
                'patient_id' => $this->request->getPost('patient_id') ?: null,
                'notes' => $this->request->getPost('notes'),
                'created_by' => $createdBy ?: 1 // Fallback to admin user ID if session is empty
            ];

            // Check for conflicts
            $conflict = $this->scheduleModel->checkConflict(
                $data['doctor_id'],
                $data['schedule_date'],
                $data['start_time'],
                $data['end_time']
            );

            if ($conflict) {
                session()->setFlashdata('error', 'Schedule conflict detected. The doctor already has an appointment at this time.');
                return redirect()->back()->withInput();
            }

            if ($this->scheduleModel->save($data)) {
                session()->setFlashdata('success', 'Schedule added successfully');
            } else {
                session()->setFlashdata('error', 'Failed to add schedule. Please check your input.');
            }

            return redirect()->to('/scheduling');
        }

        // Get doctors and patients for form
        $doctors = $this->userModel->getUsersByRole('doctor');
        $patients = $this->patientModel->findAll();

        $data = [
            'title' => 'Add Schedule',
            'doctors' => $doctors,
            'patients' => $patients
        ];

        return view('role_dashboard/admin/Scheduling/add_schedule', $data);
    }

    /**
     * Get schedule data for editing (AJAX endpoint)
     */
    public function get($id = null)
    {
        // Check authentication and permissions
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid schedule ID']);
        }

        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            return $this->response->setJSON(['success' => false, 'message' => 'Schedule not found']);
        }

        return $this->response->setJSON(['success' => true, 'schedule' => $schedule]);
    }

    /**
     * Update an existing schedule
     */
    public function update($id = null)
    {
        // Check authentication and permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        if (!$id) {
            return redirect()->to('/scheduling')->with('error', 'Invalid schedule ID');
        }

        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            return redirect()->to('/scheduling')->with('error', 'Schedule not found');
        }

        // Get the current user ID from session
        $createdBy = session()->get('userId');
        
        $data = [
            'doctor_id' => $this->request->getPost('doctor_id'),
            'title' => $this->request->getPost('description'), // Use description as title
            'description' => $this->request->getPost('description'),
            'schedule_date' => $this->request->getPost('schedule_date'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'schedule_type' => $this->request->getPost('schedule_type'),
            'location' => $this->request->getPost('location'),
            'patient_id' => $this->request->getPost('patient_id') ?: null,
            'notes' => $this->request->getPost('notes'),
            'created_by' => $createdBy ?: 1 // Fallback to admin user ID if session is empty
        ];

        // Check for conflicts (excluding current schedule)
        $conflict = $this->scheduleModel->checkConflict(
            $data['doctor_id'],
            $data['schedule_date'],
            $data['start_time'],
            $data['end_time'],
            $id // Exclude current schedule from conflict check
        );

        if ($conflict) {
            session()->setFlashdata('error', 'Schedule conflict detected. The doctor already has an appointment at this time.');
            return redirect()->back()->withInput();
        }

        if ($this->scheduleModel->update($id, $data)) {
            session()->setFlashdata('success', 'Schedule updated successfully');
        } else {
            session()->setFlashdata('error', 'Failed to update schedule. Please check your input.');
        }

        return redirect()->to('/scheduling');
    }

    /**
     * Edit an existing schedule entry
     */
    public function edit($id = null)
    {
        // Check authentication and permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        if (!$id) {
            return redirect()->to('/scheduling')->with('error', 'Invalid schedule ID');
        }

        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            return redirect()->to('/scheduling')->with('error', 'Schedule not found');
        }

        // Handle form submission for editing schedule
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'doctor_id' => $this->request->getPost('doctor_id'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'schedule_date' => $this->request->getPost('schedule_date'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'schedule_type' => $this->request->getPost('schedule_type'),
                'location' => $this->request->getPost('location'),
                'patient_id' => $this->request->getPost('patient_id') ?: null,
                'status' => $this->request->getPost('status'),
                'notes' => $this->request->getPost('notes')
            ];

            // Check for conflicts (excluding current schedule)
            $conflict = $this->scheduleModel->checkConflict(
                $data['doctor_id'],
                $data['schedule_date'],
                $data['start_time'],
                $data['end_time'],
                $id
            );

            if ($conflict) {
                session()->setFlashdata('error', 'Schedule conflict detected. The doctor already has an appointment at this time.');
                return redirect()->back()->withInput();
            }

            if ($this->scheduleModel->update($id, $data)) {
                session()->setFlashdata('success', 'Schedule updated successfully');
            } else {
                session()->setFlashdata('error', 'Failed to update schedule. Please check your input.');
            }

            return redirect()->to('/scheduling');
        }

        // Get doctors and patients for form
        $doctors = $this->userModel->getUsersByRole('doctor');
        $patients = $this->patientModel->findAll();

        $data = [
            'title' => 'Edit Schedule',
            'schedule' => $schedule,
            'doctors' => $doctors,
            'patients' => $patients
        ];

        return view('role_dashboard/admin/Scheduling/edit_schedule', $data);
    }

    /**
     * Delete a schedule entry
     */
    public function delete($id = null)
    {
        // Check authentication and permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        if (!$id) {
            return redirect()->to('/scheduling')->with('error', 'Invalid schedule ID');
        }

        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            return redirect()->to('/scheduling')->with('error', 'Schedule not found');
        }

        if ($this->scheduleModel->delete($id)) {
            session()->setFlashdata('success', 'Schedule deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete schedule');
        }

        return redirect()->to('/scheduling');
    }

    /**
     * Update schedule status (for AJAX requests)
     */
    public function updateStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        if ($this->scheduleModel->updateStatus($id, $status, $notes)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    /**
     * Get schedule details (for AJAX requests)
     */
    public function getScheduleDetails($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $schedule = $this->scheduleModel->select('schedules.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                                       ->join('users', 'users.id = schedules.doctor_id', 'left')
                                       ->join('patients', 'patients.id = schedules.patient_id', 'left')
                                       ->find($id);

        if (!$schedule) {
            return $this->response->setJSON(['error' => 'Schedule not found']);
        }

        return $this->response->setJSON($schedule);
    }
}
