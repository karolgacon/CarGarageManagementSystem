<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/ServiceRepository.php';
require_once __DIR__ . '/../repository/VehicleRepository.php';
require_once __DIR__ . '/../repository/InventoryRepository.php';
require_once __DIR__ . '/../repository/InvoiceRepository.php';

class ServiceController extends AppController {
    private ServiceRepository $serviceRepository;
    private VehicleRepository $vehicleRepository;
    private InventoryRepository $inventoryRepository;
    private InvoiceRepository $invoiceRepository;

    public function __construct() {
        parent::__construct();
        $this->serviceRepository = new ServiceRepository();
        $this->vehicleRepository = new VehicleRepository();
        $this->inventoryRepository = new InventoryRepository();
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function index()
    {
        $currentUserId   = $_SESSION['user_id']   ?? null;
        $currentUserRole = $_SESSION['user_role'] ?? 'user';

        // Filtruj usługi w zależności od roli
        if ($currentUserRole === 'admin') {
            // Admin widzi wszystkie
            $services = $this->serviceRepository->getAllServices();
        } else {
            // Zwykły user widzi tylko swoje (dla pojazdów, których jest właścicielem)
            $services = $this->serviceRepository->getServicesByUserId((int)$currentUserId);
        }

        // Dorzucamy do każdej usługi części i wyliczamy total_cost
        foreach ($services as &$service) {
            $service['parts'] = $this->serviceRepository->getServiceDetails($service['id']);
            $service['total_cost'] = $service['cost'];

            foreach ($service['parts'] as $part) {
                $service['total_cost'] += $part['total_cost'];
            }
        }
        $this->render('services', [
            'services' => $services
        ]);
    }


    public function add()
    {

        $currentUserId   = $_SESSION['user_id']   ?? null;
        $currentUserRole = $_SESSION['user_role'] ?? 'user';
        if ($this->isPost()) {
            $data = [
                'vehicle_id' => $_POST['vehicle_id'],
                'description' => $_POST['description'],
                'status' => 'pending', // Domyślny status
                'date' => $_POST['date'] ?? date('Y-m-d H:i:s'),
                'cost' => null, // Brak kosztu na tym etapie
            ];

            $this->serviceRepository->addService($data);

            $_SESSION['success'] = 'Service request submitted successfully!';
            header("Location: /services");
            exit();
        }

        // Admin – może wybrać dowolny pojazd
        if ($currentUserRole === 'admin') {
            $vehicles = $this->vehicleRepository->getAllVehicles();
        } else {
            // User – tylko pojazdy, które należą do niego
            $vehicles = $this->vehicleRepository->getVehiclesByOwner($currentUserId);
        }
        $inventory = $this->inventoryRepository->getAllItems();

        $this->render('service_add', [
            'vehicles' => $vehicles,
            'inventory' => $inventory,
        ]);
    }

    public function edit()
    {
        if ($this->isPost()) {
            $id = (int)$_POST['id'];

            // Tylko admin może edytować szczegóły
            $data = [
                'description' => $_POST['description'],
                'status' => $_POST['status'], // Możliwość zmiany statusu
                'date' => $_POST['date'] ?? date('Y-m-d H:i:s'),
                'cost' => $_POST['cost'] ?? null, // Koszt wypełniany przez admina
            ];

            $this->serviceRepository->updateService($id, $data);
            $_SESSION['success'] = 'Service updated successfully!';
            header("Location: /services");
            exit();
        }

        $id = (int)$_GET['?id'];
        $service = $this->serviceRepository->getServiceById($id);
        $this->render('service_edit', ['service' => $service]);
    }



    public function delete() {
        $id = (int)$_GET['?id'];
        $this->serviceRepository->deleteService($id);
        header("Location: /services");
        exit();
    }

    public function complete()
    {
        $id = (int)$_GET['?id'];

        // Ustaw aktualną datę i godzinę jako zakończenie zadania
        $currentDateTime = date('Y-m-d H:i:s');
        $this->serviceRepository->updateServiceDate($id, $currentDateTime);

        // Ustaw status na 'completed'
        $this->serviceRepository->updateServiceStatus($id, 'completed');

//        try{
//            $this->invoiceRepository->generateInvoice((int)$id);
//        } catch (Exception $e) {
//            $_SESSION['error'] = 'Nie udało się wygenerować faktury';
//        }

        header("Location: /services");
        exit();
    }

    public function accept()
    {
        $id = (int)$_GET['?id'];
        $service = $this->serviceRepository->getServiceById($id);

        if (!$service || $service['status'] !== 'pending') {
            $_SESSION['error'] = 'Service not found or already processed!';
            header("Location: /services");
            exit();
        }

        if ($this->isPost()) {
            // Dane przesłane przez formularz
            $data = [
                'id' => $id,
                'vehicle_id' => $service['vehicle_id'],
                'description' => $service['description'],
                'cost' => $_POST['cost'],
                'date' => $_POST['date'] ?? date('Y-m-d H:i:s'),
                'status' => 'in_progress',
            ];

            $this->serviceRepository->updateService($id, $data);

            // Obsługa części (jeśli zostały dodane)
            $this->serviceRepository->removeAllPartsFromService($id);
            if (!empty($_POST['parts'])) {
                foreach ($_POST['parts'] as $part) {
                    $partDetails = $this->inventoryRepository->getItemById($part['part_id']);
                    $totalCost = $partDetails->getPrice() * $part['quantity'];
                    $this->serviceRepository->addPartToService($id, $part['part_id'], $part['quantity'], $totalCost);
                }
            }

            $_SESSION['success'] = 'Service has been accepted!';
            header("Location: /services");
            exit();
        }

        $inventory = $this->inventoryRepository->getAllItems();

        $this->render('service_accept', [
            'service' => $service,
            'inventory' => $inventory
        ]);
    }

}
