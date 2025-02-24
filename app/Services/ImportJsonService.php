<?php

namespace App\Services;

use App\Config\Database;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Event;

class ImportJsonService
{
    private Employee $employee;
    private Event $event;
    private Booking $booking;
    private $connection;

    public function __construct()
    {
        $this->connection = Database::connect();
        $this->employee = new Employee($this->connection);
        $this->event = new Event($this->connection);
        $this->booking = new Booking($this->connection);
    }

    public function import(array $json): void
    {
        foreach ($json as $item) {
            $this->validateBookingFields($item);

            // Create or get employee
            $employeeId = $this->employee->firstOrCreate([
                'name' => $item['employee_name'],
                'email' => $item['employee_mail']
            ]);

            // Create or get event
            $eventId = $this->event->firstOrCreate([
                'id'   => $item['event_id'],
                'name' => $item['event_name'],
                'event_date' => $item['event_date']
            ]);


            // Create booking
            $this->booking->firstOrCreate([
                'fees' => $item['participation_fee'],
                'event_id' => $eventId,
                'employee_id' => $employeeId
            ]);
        }
    }

    // Validate booking fields
    public function validateBookingFields(array $json)
    {
        $requiredFields = ['participation_id', 'employee_name', 'employee_mail', 'event_id', 'event_name', 'participation_fee', 'event_date'];
        $bookingData = array_keys($json);
        $missingFields = array_diff($requiredFields, $bookingData);

        // Check if there is any missing field
        if (count($missingFields) > 0) {
            throw new \Exception('Missing required fields');
        }
    }
}
