<?php

require_once 'Repository.php';
require_once 'src/models/Service.php';

class ServiceRepository extends Repository
{
    public function countServices(): int {
        $stmt = $this->database->connect()->query("SELECT COUNT(*) as count FROM services");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getAllServices(): array
    {
        $stmt = $this->database->connect()->query("
            SELECT s.*, v.make, v.model
            FROM services s
            LEFT JOIN vehicles v ON s.vehicle_id = v.id
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addService(array $data): int
    {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO services (vehicle_id, description, status, date, cost)
            VALUES (:vehicle_id, :description, :status, :date, :cost)
            RETURNING id
        ");

        $stmt->execute($data);
        return $stmt->fetchColumn();
    }

    public function addPartToService(int $serviceId, int $partId, int $quantity, float $totalCost): void
    {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO service_parts (service_id, part_id, quantity, total_cost)
            VALUES (:service_id, :part_id, :quantity, :total_cost)
        ");

        $stmt->execute([
            'service_id' => $serviceId,
            'part_id' => $partId,
            'quantity' => $quantity,
            'total_cost' => $totalCost
        ]);
    }

    public function removeAllPartsFromService(int $serviceId): void
    {
        $stmt = $this->database->connect()->prepare("DELETE FROM service_parts WHERE service_id = :service_id");
        $stmt->execute(['service_id' => $serviceId]);
    }

    public function updateService(int $id, array $data): void
    {
        $stmt = $this->database->connect()->prepare("
        UPDATE services
        SET vehicle_id = :vehicle_id, description = :description, date = :date, cost = :cost, status = :status
        WHERE id = :id
    ");

        $stmt->execute(array_merge($data, ['id' => $id]));
    }


    public function updateServiceStatus(int $id, string $status): void
    {
        $stmt = $this->database->connect()->prepare("UPDATE services SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function deleteService(int $id): void
    {
        $stmt = $this->database->connect()->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getUpcomingServices(): array {
        $stmt = $this->database->connect()->prepare("
        SELECT * FROM services
        WHERE date >= NOW()
        ORDER BY date ASC
        LIMIT 5
    ");
        $stmt->execute();

        $services = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $services[] = new Service(
                $row['id'],
                $row['vehicle_id'],
                $row['description'],
                $row['status'],
                $row['date'],
                $row['cost']
            );
        }

        return $services;
    }

    public function getServiceById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT s.*, v.make, v.model
        FROM services s
        JOIN vehicles v ON s.vehicle_id = v.id
        WHERE s.id = :id
    ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        return $service ?: null;
    }

    public function getServiceDetails(int $serviceId): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT p.name AS part_name, sp.quantity, sp.total_cost
        FROM service_parts sp
        JOIN inventory p ON sp.part_id = p.id
        WHERE sp.service_id = :service_id
    ");
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateServiceDate(int $id, string $dateTime): void
    {
        $stmt = $this->database->connect()->prepare("
        UPDATE services
        SET date = :date
        WHERE id = :id
    ");
        $stmt->execute([
            'date' => $dateTime,
            'id' => $id
        ]);
    }

    public function getPartsByServiceId(int $serviceId): array {
        $stmt = $this->database->connect()->prepare("
        SELECT p.name, sp.quantity, p.price
        FROM service_parts sp
        JOIN inventory p ON sp.part_id = p.id
        WHERE sp.service_id = :service_id
    ");
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByServiceID(int $serviceId): ?array {
        $stmt = $this->database->connect()->prepare("
        SELECT u.*
        FROM users u
        JOIN vehicles v ON u.id = v.owner_id
        JOIN services s ON v.id = s.vehicle_id
        WHERE s.id = :service_id
    ");
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function getServicesByUserId(int $userId): array {
        $stmt = $this->database->connect()->prepare("
        SELECT s.*, v.make, v.model
        FROM services s
        JOIN vehicles v ON s.vehicle_id = v.id
        WHERE v.owner_id = :user_id
    ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServicesByStatus(string $status): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT * 
        FROM services
        WHERE status = :status
    ");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByVehicleId(int $vehicleId): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT * 
        FROM services
        WHERE vehicle_id = :vehicle_id"
        );
        $stmt->bindParam(':vehicle_id', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
