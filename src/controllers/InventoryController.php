<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/InventoryRepository.php';

class InventoryController extends AppController {
    private $inventoryRepository;

    public function __construct() {
        parent::__construct();
        $this->inventoryRepository = new InventoryRepository();
    }

    public function index() {
        $inventory = $this->inventoryRepository->getAllItems(); // Pobierz dane z repozytorium
        $this->render('inventory', ['inventory' => $inventory]); // Przekaż dane do widoku
    }

    public function add() {
        if (!$this->isPost()) {
            return $this->render('inventory_add');
        }

        $this->inventoryRepository->addItem($_POST);
        header('Location: /inventory');
        exit();
    }

    public function edit() {
        $id = $_GET['?id'] ?? null;
        error_log("GET Parameters: " . print_r($_GET, true));

        if (!$id) {
            header('Location: /inventory');
            exit();
        }

        $item = $this->inventoryRepository->getItemById($id);

        if (!$item) {
            header('Location: /inventory');
            exit();
        }

        if (!$this->isPost()) {
            return $this->render('inventory_edit', ['item' => $item]);
        }

        $this->inventoryRepository->updateItem($id, $_POST);
        header('Location: /inventory');
        exit();
    }

    public function delete() {
        $id = $_GET['?id'] ?? null;

        if (!$id) {
            header('Location: /inventory'); // Jeśli brak ID, przekierowanie na listę
            exit();
        }

        $this->inventoryRepository->deleteItem($id);
        header('Location: /inventory'); // Przekierowanie po usunięciu
        exit();
    }

}
