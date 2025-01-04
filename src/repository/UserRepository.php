<?php

require_once  "Repository.php";
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    private $users = [];

    public function getUser(string $email)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['surname'],
            $user['name'],
            $user['role']
        );
    }

    public function changePassword($password, $id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                $user->password = $password;
                return true;
            }
        }
        return false;
    }

    public function getAllUsers(): array {
        $stmt = $this->database->connect()->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $email, string $password, string $name, string $surname, string $role, ?string $photo): void {
        $stmt = $this->database->connect()->prepare("
        INSERT INTO users (email, password, name, surname, role, photo)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT), $name, $surname, $role, $photo]);
    }

    public function deleteUser(int $id): void {
        $stmt = $this->database->connect()->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateUser(int $id, string $email, string $name, string $surname, string $role, ?string $photo): void {
        $stmt = $this->database->connect()->prepare("
        UPDATE users SET email = ?, name = ?, surname = ?, role = ?, photo = ? WHERE id = ?
    ");
        $stmt->execute([$email, $name, $surname, $role, $photo, $id]);
    }

}