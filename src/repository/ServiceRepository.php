<?php

require_once 'Repository.php';
require_once 'src/models/Service.php';

class ServiceRepository extends Repository {
    public function countServices(): int {
        try {
            $stmt = $this->database->connect()->query('SELECT COUNT(*) FROM services');
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return 0; // Domyślnie zwraca 0 w przypadku błędu
        }
    }


    public function getUpcomingServices(): array {
        $stmt = $this->database->connect()->query("
            SELECT * FROM services WHERE date >= NOW() ORDER BY date ASC LIMIT 5
        ");
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

}
