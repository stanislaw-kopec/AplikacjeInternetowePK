<?php

class Profile {

    private int $id;
    private int $userId;
    private string $username;

    public function __construct(
        int $userId,
        string $username,
        int $id = 0
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getUsername(): string {
        return $this->username;
    }
}