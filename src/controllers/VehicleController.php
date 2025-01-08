<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/VehicleRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class VehicleController extends AppController {
    private VehicleRepository $vehicleRepository;
    private UserRepository $userRepository;

    public function __construct() {
        parent::__construct();
        $this->vehicleRepository = new VehicleRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(): void {
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'make_asc';

        $vehicles = $this->vehicleRepository->getVehicles($search, $sort);
        $this->render('vehicles', ['vehicles' => $vehicles]);
    }

    public function add(): void {
        $owners = $this->userRepository->getAllUsers(); // Pobieranie użytkowników jako właścicieli

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
        $id = (int)$_GET['id'];
        $this->vehicleRepository->deleteVehicle($id);
        header('Location: /vehicles');
    }
}
