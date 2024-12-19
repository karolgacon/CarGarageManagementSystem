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
            $user['name']
        );
    }

    public function addUser($email, $password)
    {
        $id = count($this->users) + 1;
        $this->users[] = new User($id, $email, $password, 1, false);
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
}