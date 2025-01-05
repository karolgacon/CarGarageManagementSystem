<?php

require_once 'src/controllers/AppController.php';
require_once 'src/repository/UserRepository.php';
require_once 'src/repository/VehicleRepository.php';
require_once 'src/repository/ServiceRepository.php';
require_once 'src/repository/InvoiceRepository.php';
require_once __DIR__.'/SecurityController.php';

class MainController extends AppController {
    private $userRepository;
    private $vehicleRepository;
    private $serviceRepository;
    private $invoiceRepository;
    private SecurityController $securityController;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->vehicleRepository = new VehicleRepository();
        $this->serviceRepository = new ServiceRepository();
        $this->invoiceRepository = new InvoiceRepository();
        $this->securityController = new SecurityController();
    }

    public function index() {
        $vehiclesCount = $this->vehicleRepository->countVehicles();
        $usersCount = count($this->userRepository->getAllUsers());
        $servicesCount = $this->serviceRepository->countServices();
        $invoicesCount = $this->invoiceRepository->countInvoices();
        $upcomingEvents = $this->serviceRepository->getUpcomingServices();
        $user = $this->securityController->getLoggedInUser();

        $this->render('mainview', [
            'vehiclesCount' => $vehiclesCount,
            'usersCount' => $usersCount,
            'servicesCount' => $servicesCount,
            'invoicesCount' => $invoicesCount,
            'upcomingEvents' => $upcomingEvents,
            'user' => $user
        ]);
    }

    public function getCalendarEvents() {
        $services = $this->serviceRepository->getUpcomingServices();
        $result = [];

        foreach ($services as $service) {
            $vehicle = $this->vehicleRepository->getVehicleById($service->getVehicleId());
            $result[] = [
                'title' => $vehicle->getMake() . ' ' . $vehicle->getModel(),
                'start' => date('Y-m-d\TH:i:s', strtotime($service->getDate())),
                'description' => $service->getDescription() // Dodaj opis
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

}
