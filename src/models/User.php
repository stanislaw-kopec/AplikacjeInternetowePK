<?php

class User {

    private int $id;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(
        string $email,
        string $password,
        int $id = 0,
        string $role = 'User'
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->role = $role;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }
}