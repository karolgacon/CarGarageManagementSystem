<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController {
    private UserRepository $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function index(): void {
        $users = $this->userRepository->getAllUsers();
        $this->render('users', ['users' => $users]);
    }

    public function add(): void {
        if ($this->isPost()) {
            $photoPath = null;

            if (!empty($_FILES['photo']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $this->render('users_add', ['messages' => ['Invalid file type. Allowed types: JPEG, PNG, GIF.']]);
                    return;
                }

                if ($_FILES['photo']['size'] > 5 * 1024 * 1024) { // 5MB limit
                    $this->render('users_add', ['messages' => ['File size must not exceed 5MB.']]);
                    return;
                }

                $photoPath = $this->uploadPhoto($_FILES['photo']);
            }

            // Dane użytkownika
            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'name' => $_POST['name'] ?? '',
                'surname' => $_POST['surname'] ?? '',
                'role' => $_POST['role'] ?? 'user',
                'photo' => $photoPath
            ];

            // Walidacja e-maila
            if ($this->userRepository->getUserByEmail($data['email'])) {
                $this->render('users_add', ['messages' => ['User with this email already exists.']]);
                return;
            }

            // Hashowanie hasła
            if (empty($data['password'])) {
                $this->render('users_add', ['messages' => ['Password cannot be empty.']]);
                return;
            }
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Dodawanie użytkownika
            try {
                $this->userRepository->addUser($data);
                header("Location: /users");
                exit();
            } catch (Exception $e) {
                $this->render('users_add', ['messages' => ['An error occurred while adding the user.']]);
            }
        }

        $this->render('users_add');
    }


    public function edit(): void {
        $id = $_GET['?id'] ?? null;

        if (!$id) {
            header("Location: /users");
            exit();
        }

        if ($this->isPost()) {
            $photoPath = $_POST['current_photo'] ?? null;

            // Obsługa nowego zdjęcia, jeśli zostało przesłane
            if (!empty($_FILES['photo']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $this->render('users_edit', ['messages' => ['Invalid file type. Allowed types: JPEG, PNG, GIF.']]);
                    return;
                }

                if ($_FILES['photo']['size'] > 5 * 1024 * 1024) { // Limit 5 MB
                    $this->render('users_edit', ['messages' => ['File size must not exceed 5MB.']]);
                    return;
                }

                $photoPath = $this->uploadPhoto($_FILES['photo']);
            }

            // Sprawdź, czy hasło jest puste
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $password, // może być null
                'name' => $_POST['name'] ?? '',
                'surname' => $_POST['surname'] ?? '',
                'role' => $_POST['role'] ?? 'user',
                'photo' => $photoPath
            ];

            // Jeśli hasło jest puste, usuń je z danych do aktualizacji
            if ($data['password'] === null) {
                unset($data['password']);
            }

            $this->userRepository->updateUser((int)$id, $data);
            header("Location: /users");
            exit();
        }

        $user = $this->userRepository->getUserById((int)$id);
        $this->render('users_edit', ['user' => $user]);
    }

    private function uploadPhoto(array $file): string {
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new RuntimeException('Failed to upload file.');
        }

        // Zwraca ścieżkę względną do zapisu w bazie danych
        return '/public/uploads/' . $fileName;
    }

    public function delete(): void {
        $id = $_GET['?id'] ?? null;

        if ($id) {
            $this->userRepository->deleteUser((int)$id);
        }

        header("Location: /users");
        exit();
    }

    public function profile() {
        $user = $this->getLoggedInUser();

        if (!$user) {
            header("Location: /login");
            exit();
        }

        $this->render('profile', ['user' => $user]);
    }

}
