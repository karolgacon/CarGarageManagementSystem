<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/VehicleRepository.php';

class VehicleController extends AppController {
    private VehicleRepository $vehicleRepository;

    public function __construct() {
        parent::__construct();
        $this->vehicleRepository = new VehicleRepository();
    }

    public function index() {
        $vehicles = $this->vehicleRepository->getAllVehicles();
        $this->render('vehicles', ['vehicles' => $vehicles]);
    }

    public function add() {
        if ($this->isPost()) {
            $data = [
                'owner_id' => $_POST['owner_id'],
                'make' => $_POST['make'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'vin' => $_POST['vin'],
                'engine_capacity' => $_POST['engine_capacity'],
            ];

            $this->vehicleRepository->addVehicle($data);
            header('Location: /vehicles');
            exit();
        }

        $this->render('vehicle_add');
    }

    public function edit() {
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
            header('Location: /vehicles');
            exit();
        }

        $id = (int)$_GET['id'];
        $vehicle = $this->vehicleRepository->getVehicleById($id);
        $this->render('vehicle_edit', ['vehicle' => $vehicle]);
    }

    public function delete() {
        $id = (int)$_GET['id'];
        $this->vehicleRepository->deleteVehicle($id);
        header('Location: /vehicles');
    }
}
