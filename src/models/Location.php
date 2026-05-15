<?php

class Location {

    private int $id;
    private string $city;

    public function __construct(
        string $city,
        int $id = 0
    ) {
        $this->city = $city;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}