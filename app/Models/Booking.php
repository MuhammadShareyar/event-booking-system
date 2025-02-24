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
}
