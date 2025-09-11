<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time',
        'duration_minutes', 'appointment_type', 'status', 'notes', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'patient_id'        => 'required|integer',
        'doctor_id'         => 'required|integer',
        'appointment_date'  => 'required|valid_date',
        'appointment_time'  => 'required',
        'appointment_type'  => 'required|min_length[3]|max_length[50]',
        'status'            => 'in_list[Scheduled,Confirmed,In Progress,Completed,Cancelled,No Show]',
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'A patient must be selected for the appointment',
        ],
        'doctor_id' => [
            'required' => 'A doctor must be assigned',
        ],
        'appointment_date' => [
            'required' => 'The appointment date is required',
            'valid_date' => 'Please provide a valid appointment date',
        ],
        'appointment_time' => [
            'required' => 'The appointment time is required',
        ],
        'appointment_type' => [
            'required' => 'The appointment type is required',
            'min_length' => 'Appointment type must be at least 3 characters',
        ],
        'status' => [
            'in_list' => 'Please select a valid status',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    //Helper Methods

    // Get appointments by doctor
    public function getAppointmentsByDoctor($doctorId, $date = null)
    {
        $builder = $this->where('doctor_id', $doctorId);

        if ($date) {
            $builder->where('appointment_date', $date);
        }

        return $builder->findAll();
    }

    // Get appointments by patient
    public function getAppointmentsByPatient($patientId)
    {
        return $this->where('patient_id', $patientId)->findAll();
    }

    public function getTodaysAppointmentsWithDetails()
    {
        return $this->select('appointments.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                    ->join('users', 'users.id = appointments.doctor_id')
                    ->join('patients', 'patients.id = appointments.patient_id')
                    ->where('appointment_date', date('Y-m-d'))
                    ->findAll();
    }

    public function getUpcomingAppointmentsWithDetails()
    {
        return $this->select('appointments.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                    ->join('users', 'users.id = appointments.doctor_id')
                    ->join('patients', 'patients.id = appointments.patient_id')
                    ->where('appointment_date >', date('Y-m-d'))
                    ->orderBy('appointment_date', 'ASC')
                    ->findAll();
    }

    public function getCompletedAppointmentsWithDetails()
    {
        return $this->select('appointments.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                    ->join('users', 'users.id = appointments.doctor_id')
                    ->join('patients', 'patients.id = appointments.patient_id')
                    ->where('appointments.status', 'Completed')
                    ->findAll();
    }


    // Get appointment stats for dashboard widgets
    public function getAppointmentStats()
    {
        return [
            'today'     => $this->where('appointment_date', date('Y-m-d'))->countAllResults(),
            'upcoming'  => $this->where('appointment_date >', date('Y-m-d'))->countAllResults(),
            'completed' => $this->where('status', 'Completed')->countAllResults(),
            'cancelled' => $this->where('status', 'Cancelled')->countAllResults(),
        ];
    }

    // Prevent overlapping schedules (server-side check)
    public function hasConflict($doctorId, $date, $time)
    {
        return $this->where('doctor_id', $doctorId)
                    ->where('appointment_date', $date)
                    ->where('appointment_time', $time)
                    ->first() !== null;
    }
}
