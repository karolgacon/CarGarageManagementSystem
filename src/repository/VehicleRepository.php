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
        $data['engine_capacity'] = (int)($data['engine_capacity'] * 1000); // Konwersja z litrów na mililitry

        $stmt = $this->database->connect()->prepare('
        INSERT INTO vehicles (owner_id, make, model, year, vin, engine_capacity)
        VALUES (:owner_id, :make, :model, :year, :vin, :engine_capacity)
    ');
        $stmt->bindParam(':owner_id', $data['owner_id'], PDO::PARAM_INT);
        $stmt->bindParam(':make', $data['make'], PDO::PARAM_STR);
        $stmt->bindParam(':model', $data['model'], PDO::PARAM_STR);
        $stmt->bindParam(':year', $data['year'], PDO::PARAM_INT);
        $stmt->bindParam(':vin', $data['vin'], PDO::PARAM_STR);
        $stmt->bindParam(':engine_capacity', $data['engine_capacity'], PDO::PARAM_INT);
        $stmt->execute();
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

    public function getVehicles(string $search = '', string $sort = 'make_asc'): array {
        $query = 'SELECT * FROM vehicles WHERE 1=1';
        $params = [];

        // Wyszukiwanie
        if (!empty($search)) {
            $query .= ' AND (make ILIKE :search OR model ILIKE :search OR vin ILIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }

        // Sortowanie
        switch ($sort) {
            case 'make_desc':
                $query .= ' ORDER BY make DESC';
                break;
            case 'year_asc':
                $query .= ' ORDER BY year ASC';
                break;
            case 'year_desc':
                $query .= ' ORDER BY year DESC';
                break;
            case 'make_asc':
            default:
                $query .= ' ORDER BY make ASC';
                break;
        }

        $stmt = $this->database->connect()->prepare($query);
        $stmt->execute($params);

        $vehicles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vehicles[] = new Vehicle($row['id'], $row['owner_id'], $row['make'], $row['model'], $row['year'], $row['vin'], $row['engine_capacity']);
        }

        return $vehicles;
    }

    public function checkIfVinExists(string $vin): bool
    {
        $stmt = $this->database->connect()->prepare("
        SELECT COUNT(*) AS count FROM vehicles WHERE vin = :vin
    ");
        $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function countVehiclesByUserId(int $userId): int {
        $stmt = $this->database->connect()->prepare("
        SELECT COUNT(*) as count
        FROM vehicles
        WHERE owner_id = :user_id
    ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }


}
