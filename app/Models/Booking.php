<?php

namespace App\Models;

use PDO;

class Booking
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function firstOrCreate(array $data): bool
    {
        $sql = "SELECT id FROM bookings WHERE event_id = :event_id AND employee_id = :employee_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':event_id' => $data['event_id'], ':employee_id' => $data['employee_id']]);

        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee) {
            return true;
        }

        $sql = "INSERT INTO bookings (event_id, employee_id,fees) VALUES (:event_id, :employee_id,:fees)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ":event_id" => $data["event_id"],
            ":employee_id" => $data["employee_id"],
            ":fees" => $data["fees"]
        ]);;
    }

    public function getAll(string $employeeName = '', string $eventName = '', string $bookingDate = null): array
    {
        $sql = "
            SELECT ev.name as event_name, emp.name, bookings.fees, ev.event_date FROM bookings 
            inner join events as ev on bookings.event_id = ev.id 
            inner join employees as emp on bookings.employee_id = emp.id
            WHERE (:employee_name = '' OR emp.name LIKE :employee_name)
            AND (:event_name = '' OR ev.name LIKE :event_name)
            AND (:event_date IS NULL OR ev.event_date = :event_date)    
        ";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':employee_name' => $employeeName ?  '%' . $employeeName . '%' : '',
            ':event_name' => $eventName ?  '%' . $eventName . '%' : '',
            ':event_date' => $bookingDate ?: null
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
