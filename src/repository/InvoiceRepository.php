<?php

require_once 'Repository.php';
require_once 'src/models/Invoice.php';

class InvoiceRepository extends Repository {
    public function countInvoices(): int {
        $stmt = $this->database->connect()->query('SELECT COUNT(*) FROM invoices');
        return $stmt->fetchColumn();
    }

    public function getInvoices(): array {
        $stmt = $this->database->connect()->query('SELECT * FROM invoices');
        $invoices = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invoices[] = new Invoice(
                $row['id'],
                $row['amount'],
                $row['status'],
                $row['issue_date']
            );
        }
        return $invoices;
    }
}
