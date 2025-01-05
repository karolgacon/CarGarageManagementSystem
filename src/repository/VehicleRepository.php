<?php

require_once 'Repository.php';
require_once 'src/models/Vehicle.php';


class VehicleRepository extends Repository {
    public function countVehicles(): int {
        $stmt = $this->database->connect()->query('SELECT COUNT(*) FROM vehicles');
        return (int) $stmt->fetchColumn();
    }

    public function getAllVehicles(): array {
        $stmt = $this->database->connect()->query('SELECT * FROM vehicles');
        $vehicles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vehicles[] = new Vehicle($row['id'], $row['owner_id'], $row['make'], $row['model'], $row['year'], $row['vin'], $row['engine_capacity']);
        }
        return $vehicles;
    }

    public function addVehicle(array $data): void {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO vehicles (owner_id, make, model, year, vin, engine_capacity)
            VALUES (:owner_id, :make, :model, :year, :vin, :engine_capacity)
        ');
        $stmt->execute($data);
    }

    public function getVehicleById(int $id): ?Vehicle {
        $stmt = $this->database->connect()->prepare('SELECT * FROM vehicles WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Vehicle($row['id'], $row['owner_id'], $row['make'], $row['model'], $row['year'], $row['vin'], $row['engine_capacity']);
    }

    public function updateVehicle(int $id, array $data): void {
        $stmt = $this->database->connect()->prepare('
            UPDATE vehicles SET 
                owner_id = :owner_id,
                make = :make,
                model = :model,
                year = :year,
                vin = :vin,
                engine_capacity = :engine_capacity
            WHERE id = :id
        ');
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function deleteVehicle(int $id): void {
        $stmt = $this->database->connect()->prepare('DELETE FROM vehicles WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
