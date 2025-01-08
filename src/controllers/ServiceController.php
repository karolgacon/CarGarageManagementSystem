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
        $services = $this->serviceRepository->getAllServices();

        foreach ($services as &$service) {
            $service['parts'] = $this->serviceRepository->getServiceDetails($service['id']);
            $service['total_cost'] = $service['cost']; // Koszt serwisu

            // Dodajemy koszt części
            foreach ($service['parts'] as $part) {
                $service['total_cost'] += $part['total_cost'];
            }
        }

        $this->render('services', ['services' => $services]);
    }


    public function add()
    {
        if ($this->isPost()) {
            $data = [
                'vehicle_id' => $_POST['vehicle_id'],
                'description' => $_POST['description'],
                'status' => 'pending',
                'date' => $_POST['date'] ?? date('Y-m-d H:i:s'),
                'cost' => $_POST['cost'],
            ];

            $serviceId = $this->serviceRepository->addService($data);

            foreach ($_POST['parts'] as $part) {
                $partDetails = $this->inventoryRepository->getItemById($part['part_id']);
                $totalCost = $partDetails->getPrice() * $part['quantity'];
                $this->serviceRepository->addPartToService($serviceId, $part['part_id'], $part['quantity'], $totalCost);
            }

            header("Location: /services");
            exit();
        }

        $vehicles = $this->vehicleRepository->getAllVehicles();
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
            $data = [
                'vehicle_id' => $_POST['vehicle_id'],  // Dodaj vehicle_id
                'description' => $_POST['description'],
                'status' => $_POST['status'],
                'date' => $_POST['date'] ?? date('Y-m-d H:i:s'),
                'cost' => $_POST['cost']
            ];

            $this->serviceRepository->updateService($id, $data);
            header("Location: /services");
            exit();
        }

        $id = (int)$_GET['?id'];
        $service = $this->serviceRepository->getServiceById($id);
        $vehicles = $this->vehicleRepository->getAllVehicles();
        $this->render('service_edit', ['service' => $service, 'vehicles' => $vehicles]);
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


}
