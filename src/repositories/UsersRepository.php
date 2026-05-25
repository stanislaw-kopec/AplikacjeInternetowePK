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

    public function getUserById(int $id): ?User
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM users WHERE id = :id"
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['id'],
            $user['role'] ?? 'User'
        );
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
            $user['id'],
            $user['role'] ?? 'User'
        );
    }

    public function createUser(User $user): int
    {
        $this->ensureRoleColumnExists();

        $query = $this->database->connect()->prepare(
            "INSERT INTO users (email, password, role)
             VALUES (:email, :password, :role)
             RETURNING id"
        );

        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->bindParam(':role', $role);

        $query->execute();

        return (int)$query->fetchColumn();
    }

    private function ensureRoleColumnExists(): void
    {
        $this->database->connect()->exec(
            "ALTER TABLE users
             ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'User' NOT NULL"
        );
    }
}
