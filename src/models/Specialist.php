<?php

class Specialist {

    private int $id;
    private string $name;
    private string $profession;

    public function __construct(
        string $name,
        string $profession,
        int $id = 0
    ) {
        $this->name = $name;
        $this->profession = $profession;
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getProfession(): string {
        return $this->profession;
    }
}