<?php

namespace App\Models;

use PDO;

class Event
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function firstOrCreate(array $data): int
    {
        $sql = "SELECT id FROM events WHERE name = :name and id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':name' => $data['name'], ':id' => $data['id']]);

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            return (int)$event['id'];
        }

        $sql = "INSERT INTO events (name, event_date) VALUES (:name, :event_date)";
        $stmt = $this->connection->prepare($sql);

        $event = $stmt->execute([
            ":name" => $data["name"],
            ":event_date" => $data["event_date"]
        ]);

        return $this->connection->lastInsertId();
    }
}
