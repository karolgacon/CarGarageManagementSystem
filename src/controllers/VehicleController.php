<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/VehicleRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class VehicleController extends AppController {
    private ServiceRepository $serviceRepository;
    private VehicleRepository $vehicleRepository;
    private UserRepository $userRepository;

    public function __construct() {
        parent::__construct();
        $this->vehicleRepository = new VehicleRepository();
        $this->userRepository = new UserRepository();
        $this->serviceRepository = new ServiceRepository();
    }

    public function index(): void
    {
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'make_asc';

        // Załóżmy, że w sesji trzymasz user_id i user_role
        $currentUserId = $_SESSION['user_id'] ?? null;
        $currentUserRole = $_SESSION['user_role'] ?? 'user';

        // Rozdzielamy logikę:
        if ($currentUserRole === 'admin') {
            // Administrator widzi wszystkie pojazdy
            $vehicles = $this->vehicleRepository->getVehicles($search, $sort);
        } else {
            // Zwykły user widzi tylko swoje pojazdy
            $vehicles = $this->vehicleRepository->getVehiclesByOwner($currentUserId, $search, $sort);
        }

        // Tworzymy tablicę $owners -> [ownerID => ['name'=>'...', 'surname'=>'...']]
        $owners = [];
        foreach ($vehicles as $v) {
            $ownerID = $v->getOwnerId();
            // getUserById zwraca obiekt usera
            $owner = $this->userRepository->getUserById($ownerID);
            if ($owner) {
                $owners[$ownerID] = [
                    'name' => $owner->getName(),
                    'surname' => $owner->getSurname()
                ];
            }
        }

        $this->render('vehicles', [
            'vehicles' => $vehicles,
            'owners'   => $owners
        ]);
    }


    public function add(): void {

        $currentUserId = $_SESSION['user_id'] ?? null;
        $currentUserRole = $_SESSION['user_role'] ?? 'user';

        // Rozdzielamy logikę:
        if ($currentUserRole === 'admin') {
            $owners = $this->userRepository->getAllUsers(); // Pobieranie użytkowników jako właścicieli
        } else {
            $singleOwner = $this->userRepository->getUserById($currentUserId);
            $owners = $singleOwner ? [$singleOwner] : [];
        }
        if ($this->isPost()) {
            $data = [
                'owner_id' => $_POST['owner_id'],
                'make' => $_POST['make'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'vin' => $_POST['vin'],
                'engine_capacity' => $_POST['engine_capacity']
            ];
            if ($this->vehicleRepository->checkIfVinExists($data['vin'])) {
                $_SESSION['error'] = 'Vehicle with this VIN already exists.';
                header("Location: /vehicle_add");
                exit();
            }
            $this->vehicleRepository->addVehicle($data);
            header('Location: /vehicles');
            exit();
        }

        $this->render('vehicle_add', ['owners' => $owners]);
    }


    public function edit(): void {
        if ($this->isPost()) {
            $id = (int)$_POST['id'];
            $data = [
                'owner_id' => $_POST['owner_id'],
                'make' => $_POST['make'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'vin' => $_POST['vin'],
                'engine_capacity' => $_POST['engine_capacity'],
            ];

            $this->vehicleRepository->updateVehicle($id, $data);
            header("Location: /vehicles");
            exit();
        }

        $id = (int)$_GET['?id'];
        $vehicle = $this->vehicleRepository->getVehicleById($id);
        $owners = $this->userRepository->getAllUsers(); // Pobieranie listy właścicieli

        $this->render('vehicle_edit', [
            'vehicle' => $vehicle,
            'owners' => $owners,
        ]);
    }


    public function delete() {
        $id = (int)$_GET['?id'];
        $this->vehicleRepository->deleteVehicle($id);
        header('Location: /vehicles');
    }

    public function history(): void
    {
        // 1) Pobranie ID z GET
        $vehicleId = $_GET['?id'] ?? null;
        if (!$vehicleId) {
            // Możesz zrobić redirect, rzucić wyjątek itp.
            die('Missing vehicle ID!');
        }

        // 2) Pobranie pojazdu z bazy
        $vehicle = $this->vehicleRepository->getVehicleById($vehicleId);
        if (!$vehicle) {
            die('Vehicle not found!');
        }

        // 3) Pobranie usług (historii serwisów) dla tego pojazdu
        $services = $this->serviceRepository->findByVehicleId($vehicleId);

        // 4) Przekazanie danych do widoku
        $this->render('vehicle_history', [
            'vehicle' => $vehicle,
            'services' => $services
        ]);
    }

}
