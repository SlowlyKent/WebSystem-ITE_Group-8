<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'doctor_id', 'title', 'description', 'schedule_date', 'start_time', 'end_time',
        'schedule_type', 'location', 'patient_id', 'status', 'notes', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'doctor_id' => 'required|integer',
        'description' => 'required|min_length[3]|max_length[255]',
        'schedule_date' => 'required|valid_date',
        'start_time' => 'required',
        'end_time' => 'required',
        'schedule_type' => 'required|in_list[consultation,surgery,rounds,emergency,meeting,other]',
    ];

    protected $validationMessages = [
        'doctor_id' => [
            'required' => 'Doctor is required',
            'integer' => 'Invalid doctor selection',
        ],
        'description' => [
            'required' => 'Schedule description is required',
            'min_length' => 'Description must be at least 3 characters long',
        ],
        'schedule_date' => [
            'required' => 'Schedule date is required',
            'valid_date' => 'Please enter a valid date',
        ],
        'start_time' => [
            'required' => 'Start time is required',
        ],
        'end_time' => [
            'required' => 'End time is required',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Get schedules for a specific doctor
    public function getSchedulesByDoctor($doctorId, $startDate = null, $endDate = null)
    {
        $builder = $this->select('schedules.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                        ->join('users', 'users.id = schedules.doctor_id', 'left')
                        ->join('patients', 'patients.id = schedules.patient_id', 'left')
                        ->where('schedules.doctor_id', $doctorId)
                        ->orderBy('schedules.schedule_date', 'ASC')
                        ->orderBy('schedules.start_time', 'ASC');

        if ($startDate) {
            $builder->where('schedules.schedule_date >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('schedules.schedule_date <=', $endDate);
        }

        return $builder->findAll();
    }

    // Get today's schedules for a doctor
    public function getTodaySchedules($doctorId)
    {
        return $this->getSchedulesByDoctor($doctorId, date('Y-m-d'), date('Y-m-d'));
    }

    // Get upcoming schedules for a doctor
    public function getUpcomingSchedules($doctorId, $limit = 10)
    {
        return $this->select('schedules.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                    ->join('users', 'users.id = schedules.doctor_id', 'left')
                    ->join('patients', 'patients.id = schedules.patient_id', 'left')
                    ->where('schedules.doctor_id', $doctorId)
                    ->where('schedules.schedule_date >=', date('Y-m-d'))
                    ->where('schedules.status !=', 'cancelled')
                    ->orderBy('schedules.schedule_date', 'ASC')
                    ->orderBy('schedules.start_time', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    // Get all schedules with doctor and patient details
    public function getAllSchedulesWithDetails($startDate = null, $endDate = null)
    {
        $builder = $this->select('schedules.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                        ->join('users', 'users.id = schedules.doctor_id', 'left')
                        ->join('patients', 'patients.id = schedules.patient_id', 'left')
                        ->orderBy('schedules.schedule_date', 'ASC')
                        ->orderBy('schedules.start_time', 'ASC');

        if ($startDate) {
            $builder->where('schedules.schedule_date >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('schedules.schedule_date <=', $endDate);
        }

        return $builder->findAll();
    }

    // Check for schedule conflicts
    public function checkConflict($doctorId, $date, $startTime, $endTime, $excludeId = null)
    {
        $builder = $this->where('doctor_id', $doctorId)
                        ->where('schedule_date', $date)
                        ->where('status !=', 'cancelled')
                        ->groupStart()
                            ->groupStart()
                                ->where('start_time <=', $startTime)
                                ->where('end_time >', $startTime)
                            ->groupEnd()
                            ->orGroupStart()
                                ->where('start_time <', $endTime)
                                ->where('end_time >=', $endTime)
                            ->groupEnd()
                            ->orGroupStart()
                                ->where('start_time >=', $startTime)
                                ->where('end_time <=', $endTime)
                            ->groupEnd()
                        ->groupEnd();

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->first();
    }

    // Get schedule statistics for dashboard
    public function getScheduleStats($doctorId = null)
    {
        $today = date('Y-m-d');
        
        $stats = [];
        
        // Base query
        $baseQuery = $this->where('schedule_date', $today);
        if ($doctorId) {
            $baseQuery->where('doctor_id', $doctorId);
        }
        
        $stats['today_total'] = (clone $baseQuery)->countAllResults();
        $stats['today_completed'] = (clone $baseQuery)->where('status', 'completed')->countAllResults();
        $stats['today_pending'] = (clone $baseQuery)->where('status', 'scheduled')->countAllResults();
        $stats['today_in_progress'] = (clone $baseQuery)->where('status', 'in_progress')->countAllResults();
        
        // Upcoming schedules (next 7 days)
        $nextWeek = date('Y-m-d', strtotime('+7 days'));
        $upcomingQuery = $this->where('schedule_date >', $today)
                              ->where('schedule_date <=', $nextWeek)
                              ->where('status !=', 'cancelled');
        if ($doctorId) {
            $upcomingQuery->where('doctor_id', $doctorId);
        }
        
        $stats['upcoming_week'] = $upcomingQuery->countAllResults();
        
        return $stats;
    }

    // Update schedule status
    public function updateStatus($scheduleId, $status, $notes = null)
    {
        $data = ['status' => $status];
        if ($notes) {
            $data['notes'] = $notes;
        }
        
        return $this->update($scheduleId, $data);
    }

    // Get schedules by date range for calendar view
    public function getSchedulesForCalendar($startDate, $endDate, $doctorId = null)
    {
        $builder = $this->select('schedules.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name, patients.first_name as patient_first_name, patients.last_name as patient_last_name')
                        ->join('users', 'users.id = schedules.doctor_id', 'left')
                        ->join('patients', 'patients.id = schedules.patient_id', 'left')
                        ->where('schedules.schedule_date >=', $startDate)
                        ->where('schedules.schedule_date <=', $endDate)
                        ->orderBy('schedules.schedule_date', 'ASC')
                        ->orderBy('schedules.start_time', 'ASC');

        if ($doctorId) {
            $builder->where('schedules.doctor_id', $doctorId);
        }

        return $builder->findAll();
    }
}
