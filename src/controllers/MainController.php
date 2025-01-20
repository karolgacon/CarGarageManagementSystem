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
        // Pobierz ID aktualnie zalogowanego użytkownika
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId === null) {
            header("Location: /login");
            exit();
        }

        // Pobierz dane użytkownika
        $user = $this->userRepository->getUserById($userId);

        // Różnicowanie widoku w zależności od roli użytkownika
        if ($user->getRole() === 'admin') {
            $this->showAdminDashboard($user);
        } else {
            $this->showUserDashboard($user);
        }
    }

    private function showAdminDashboard($user) {
        // Pobierz dane globalne dla administratora
        $invoices = $this->invoiceRepository->getAllInvoices();
        $services = $this->serviceRepository->getAllServices();
        $vehiclesCount = $this->vehicleRepository->countVehicles();
        $usersCount = count($this->userRepository->getAllUsers());
        $servicesCount = $this->serviceRepository->countServices();
        $invoicesCount = $this->invoiceRepository->countInvoices();

        // Przekaż dane do widoku
        $this->render('admin_dashboard', [
            'user' => $user,
            'vehiclesCount' => $vehiclesCount,
            'usersCount' => $usersCount,
            'servicesCount' => $servicesCount,
            'invoicesCount' => $invoicesCount,
            'invoices' => $invoices,
            'services' => $services
        ]);
    }

    private function showUserDashboard($user) {
        // Pobierz dane przypisane do użytkownika
        $invoices = $this->invoiceRepository->getInvoicesByUserId($user->getId());
        $services = $this->serviceRepository->getServicesByUserId($user->getId());
        $vehiclesCount = $this->vehicleRepository->countVehiclesByUserId($user->getId());
        $servicesCount = count($services);
        $invoicesCount = count($invoices);

        // Przekaż dane do widoku
        $this->render('user_dashboard', [
            'user' => $user,
            'vehiclesCount' => $vehiclesCount,
            'servicesCount' => $servicesCount,
            'invoicesCount' => $invoicesCount,
            'invoices' => $invoices,
            'services' => $services
        ]);
    }


    public function getCalendarEvents() {
        try {
            // Pobierz ID zalogowanego użytkownika
            $userId = $_SESSION['user_id'] ?? null;

            if ($userId === null) {
                http_response_code(401); // Unauthorized
                echo json_encode(['error' => 'Nie zalogowano użytkownika']);
                exit;
            }

            // Pobierz usługi przypisane do użytkownika
            $services = $this->serviceRepository->getServicesByUserId($userId);
            $result = [];

            foreach ($services as $service) {
                // Pobierz pojazd powiązany z usługą
                $vehicle = $this->vehicleRepository->getVehicleById($service['vehicle_id']);

                if (!$vehicle) {
                    continue; // Pomiń usługi bez pojazdów
                }

                // Dodaj wydarzenie do kalendarza
                $result[] = [
                    'title' => $vehicle->getMake() . ' ' . $vehicle->getModel(),
                    'start' => date('Y-m-d\TH:i:s', strtotime($service['date'])),
                    'description' => $service['description']
                ];
            }

            // Ustaw nagłówek Content-Type na JSON
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (Exception $e) {
            // Obsługa błędów
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Wystąpił błąd podczas generowania wydarzeń.', 'details' => $e->getMessage()]);
        }
        exit;
    }


}
