<?php

namespace App\Models;

use PDO;

class Employee
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function firstOrCreate(array $data): int
    {
        $sql = "SELECT id FROM employees WHERE name = :name AND email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email' => $data['email'], ':name' => $data['name']]);

        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee) {
            return (int)$employee['id'];
        }

        $sql = "INSERT INTO employees (name, email) VALUES (:name, :email)";
        $stmt = $this->connection->prepare($sql);

        $employee = $stmt->execute([
            ":name" => $data["name"],
            ":email" => $data["email"]
        ]);

        return $this->connection->lastInsertId();
    }
}
