<?php

require_once 'Repository.php';
require_once 'src/models/Invoice.php';
require_once 'src/repository/ServiceRepository.php';

class InvoiceRepository extends Repository {

    private ServiceRepository $serviceRepository;

    public function __construct() {
        parent::__construct();
        $this->serviceRepository = new ServiceRepository(); // Inicjalizacja ServiceRepository
    }
    public function countInvoices(): int {
        $stmt = $this->database->connect()->query('SELECT COUNT(*) FROM invoices');
        return $stmt->fetchColumn();
    }

    public function getAllInvoices(string $sort = 'created_at_desc'): array {
        $sortOptions = [
            'created_at_asc' => 'i.created_at ASC',
            'created_at_desc' => 'i.created_at DESC',
            'amount_asc' => 'i.amount ASC',
            'amount_desc' => 'i.amount DESC',
            'status_updated_at_asc' => 'i.status_updated_at ASC',
            'status_updated_at_desc' => 'i.status_updated_at DESC',
        ];

        $orderBy = $sortOptions[$sort] ?? $sortOptions['created_at_desc'];

        $stmt = $this->database->connect()->prepare("
        SELECT i.id, i.service_id, i.invoice_number, i.amount, i.status, i.created_at, i.vat, i.status_updated_at,
               u.name AS first_name, u.surname AS last_name
        FROM invoices i
        JOIN services s ON i.service_id = s.id
        JOIN vehicles v ON s.vehicle_id = v.id
        JOIN users u ON v.owner_id = u.id
        ORDER BY $orderBy
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Pobierz fakturę po ID
    public function getInvoiceById(int $id): ?array {
        $stmt = $this->database->connect()->prepare("
            SELECT id, service_id, invoice_number, amount, status, created_at, vat, status_updated_at
            FROM invoices
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        return $invoice ?: null;
    }

    // Dodaj nową fakturę
    public function addInvoice(array $data): int {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO invoices (service_id, invoice_number, amount, status, created_at, vat, status_updated_at)
            VALUES (:service_id, :invoice_number, :amount, :status, :created_at, :vat, NOW())
        ");
        $stmt->execute([
            'service_id' => $data['service_id'],
            'invoice_number' => $data['invoice_number'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'created_at' => $data['created_at'] ?? date('Y-m-d H:i:s'),
            'vat' => $data['vat']

        ]);
        return $this->database->connect()->lastInsertId();
    }

    // Zaktualizuj status faktury
    public function updateInvoiceStatus(int $id, string $status): void {
        $stmt = $this->database->connect()->prepare("
        UPDATE invoices
        SET status = :status, status_updated_at = NOW()
        WHERE id = :id
    ");
        $stmt->execute([
            'status' => $status,
            'id' => $id
        ]);
    }


    // Usuń fakturę
    public function deleteInvoice(int $id): void {
        $stmt = $this->database->connect()->prepare("
            DELETE FROM invoices WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getInvoicesByUserId(int $userId): array {
        $stmt = $this->database->connect()->prepare("
        SELECT i.*, u.name AS first_name, u.surname AS last_name
        FROM invoices i
        JOIN services s ON i.service_id = s.id
        JOIN vehicles v ON s.vehicle_id = v.id
        JOIN users u ON v.owner_id = u.id
        WHERE v.owner_id = :user_id
    ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function generateInvoice(int $serviceId): void {
        // Pobierz szczegóły usługi
        $service = $this->serviceRepository->getServiceById($serviceId);

        if (!$service || $service['status'] !== 'completed') {
            throw new Exception("Service is not completed or does not exist.");
        }

        // Oblicz sumę części i koszt usługi
        $parts = $this->serviceRepository->getPartsByServiceId($serviceId);
        $partsTotal = 0;
        foreach ($parts as $part) {
            $partsTotal += $part['quantity'] * $part['price'];
        }
        $totalAmount = $service['cost'] + $partsTotal;
// Generowanie unikalnego numeru faktury
        $invoiceNumber = $this->generateInvoiceNumber();

// Wstawienie faktury do bazy danych
        $stmt = $this->database->connect()->prepare("
    INSERT INTO invoices (service_id, amount, status, created_at, invoice_number)
    VALUES (:service_id, :amount, :status, NOW(), :invoice_number)
");
        $stmt->execute([
            'service_id' => $serviceId,
            'amount' => $totalAmount,
            'status' => 'unpaid',
            'invoice_number' => $invoiceNumber
        ]);

    }

    private function generateInvoiceNumber(): string {
        $stmt = $this->database->connect()->prepare("
        SELECT MAX(invoice_number) AS max_number FROM invoices
    ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastNumber = $result['max_number'] ?? 0;
        $newNumber = (int)$lastNumber + 1;

        return str_pad((string)$newNumber, 6, '0', STR_PAD_LEFT); // Numer faktury z 6 cyframi, np. 000001
    }



}
