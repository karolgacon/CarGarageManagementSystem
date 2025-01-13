<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/InvoiceRepository.php';
require_once __DIR__ . '/../repository/ServiceRepository.php';
require_once __DIR__ . '/../library/fpdf186/fpdf.php';

class InvoiceController extends AppController {
    private InvoiceRepository $invoiceRepository;
    private ServiceRepository $serviceRepository;

    public function __construct() {
        parent::__construct();
        $this->invoiceRepository = new InvoiceRepository();
        $this->serviceRepository = new ServiceRepository();
    }

    // Wyświetlenie listy faktur
    public function index(): void {
        $sort = $_GET['?sort'] ?? 'created_at_desc'; // Domyślne sortowanie
        $invoices = $this->invoiceRepository->getAllInvoices($sort);

        $this->render('invoices', [
            'invoices' => $invoices,
            'sort' => $sort
        ]);
    }


    // Szczegóły faktury
    public function details(): void {
        $id = isset($_GET['?id']) ? (int)$_GET['?id'] : null;

        if ($id === null) {
            $_SESSION['error'] = 'Invoice ID is required.';
            header('Location: /invoices');
            exit();
        }

        $invoice = $this->invoiceRepository->getInvoiceById($id);
        if (!$invoice) {
            $_SESSION['error'] = 'Invoice not found.';
            header('Location: /invoices');
            exit();
        }

        $service = $this->serviceRepository->getServiceById($invoice['service_id']);
        $parts = $this->serviceRepository->getPartsByServiceId($invoice['service_id']);
        $client = $this->serviceRepository->getUserByServiceID($invoice['service_id']);

        $this->render('invoice_details', [
            'invoice' => $invoice,
            'service' => $service,
            'parts' => $parts,
            'client' => $client
        ]);
    }

    // Generowanie faktury
    public function generateInvoice(int $serviceId): void {
        $invoiceData = [
            'service_id' => $serviceId,
            'invoice_number' => $this->generateInvoiceNumber(),
            'status' => 'unpaid',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->invoiceRepository->addInvoice($invoiceData);
        header("Location: /invoices");
        exit();
    }


    // Usuń fakturę
    public function delete(): void {
        $id = isset($_GET['?id']) ? (int)$_GET['?id'] : null;

        if ($id === null) {
            $_SESSION['error'] = 'Invoice ID is required.';
            header('Location: /invoices');
            exit();
        }

        $this->invoiceRepository->deleteInvoice($id);
        header("Location: /invoices");
        exit();
    }

    // Oznaczenie faktury jako opłaconej
    public function markAsPaid(): void {
        $id = isset($_GET['?id']) ? (int)$_GET['?id'] : null;

        if ($id === null) {
            $_SESSION['error'] = 'Invoice ID is required.';
            header('Location: /invoices');
            exit();
        }

        $this->invoiceRepository->updateInvoiceStatus($id, 'paid');
        header("Location: /invoices");
        exit();
    }

    // Generowanie unikalnego numeru faktury
    private function generateInvoiceNumber(): string {
        return 'INV-' . strtoupper(uniqid());
    }

    public function exportToPDF(): void {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

        if ($id === null) {
            $_SESSION['error'] = 'Invoice ID is required.';
            header('Location: /invoices');
            exit();
        }

        $invoice = $this->invoiceRepository->getInvoiceById($id);
        if (!$invoice) {
            $_SESSION['error'] = 'Invoice not found.';
            header('Location: /invoices');
            exit();
        }

        $service = $this->serviceRepository->getServiceById($invoice['service_id']);
        $parts = $this->serviceRepository->getPartsByServiceId($invoice['service_id']);
        $client = $this->serviceRepository->getUserByServiceID($invoice['service_id']);


        // Tworzenie nowego PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Nagłówek faktury
        $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');
        $pdf->Ln(10);

        // Szczegóły klienta
        $pdf->Cell(0, 10, 'Client Details:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $this->addRowToPDF($pdf, 'Client Name:', $client['name'] . ' ' . $client['surname']);
        $this->addRowToPDF($pdf, 'Invoice Number:', $invoice['invoice_number']);
        $pdf->Ln(10);

        // Szczegóły faktury
        $pdf->SetFont('Arial', '', 12);
        $this->addRowToPDF($pdf, 'Invoice Number:', $invoice['invoice_number']);
        $this->addRowToPDF($pdf, 'Date:', date('Y-m-d H:i', strtotime($invoice['created_at'])));
        $this->addRowToPDF($pdf, 'Status:', ucfirst($invoice['status']));
        $pdf->Ln(10);

        // Szczegóły usługi
        $pdf->Cell(0, 10, 'Service Details:', 0, 1);
        $this->addRowToPDF($pdf, 'Description:', $service['description']);
        $this->addRowToPDF($pdf, 'Service Cost:', number_format($service['cost'], 2) . ' USD');
        $pdf->Ln(10);

        // Szczegóły części
        $pdf->Cell(0, 10, 'Parts Used:', 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(70, 10, 'Part', 1);
        $pdf->Cell(30, 10, 'Quantity', 1);
        $pdf->Cell(40, 10, 'Unit Price', 1);
        $pdf->Cell(40, 10, 'Total', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        $partsTotal = 0;
        foreach ($parts as $part) {
            $partTotal = $part['quantity'] * $part['price'];
            $partsTotal += $partTotal;

            $pdf->Cell(70, 10, $part['name'], 1);
            $pdf->Cell(30, 10, $part['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($part['price'], 2) . ' USD', 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($partTotal, 2) . ' USD', 1, 0, 'C');
            $pdf->Ln();
        }

        // Podsumowanie
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $this->addRowToPDF($pdf, 'Total Amount (Net):', number_format($invoice['amount'], 2) . ' USD');
        $this->addRowToPDF($pdf, 'VAT (23%):', number_format($invoice['amount'] * 0.23, 2) . ' USD');
        $this->addRowToPDF($pdf, 'Total Amount (Gross):', number_format($invoice['amount'] * 1.23, 2) . ' USD');

        // Eksport PDF do przeglądarki
        $pdf->Output('I', 'Invoice_' . $invoice['invoice_number'] . '.pdf');
        exit();
    }

    /**
     * Pomocnicza funkcja do dodawania wiersza do PDF
     */
    private function addRowToPDF(FPDF $pdf, string $label, string $value): void {
        $pdf->Cell(50, 10, $label, 0, 0);
        $pdf->Cell(0, 10, $value, 0, 1);
    }

}
