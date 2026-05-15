<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UsersRepository extends Repository {

    public function getUsers(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM users"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail(string $email): ?User
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM users WHERE email = :email"
        );

        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['id']
        );
    }

    public function createUser(User $user): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO users (email, password)
             VALUES (:email, :password)"
        );

        $email = $user->getEmail();
        $password = $user->getPassword();

        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);

        $query->execute();
    }
}