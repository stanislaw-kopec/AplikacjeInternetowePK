<?php

class Specialist {

    private int $id;
    private string $name;
    private string $profession;
    private string $phone;  // NOWE POLE
    private ?float $averageRating;
    private ?int $reviewCount;
    private array $locations;
    private array $reviews;

    public function __construct(
        string $name,
        string $profession,
        string $phone = '',      // NOWY PARAMETR
        int $id = 0,
        ?float $averageRating = null,
        ?int $reviewCount = null
    ) {
        $this->name = $name;
        $this->profession = $profession;
        $this->phone = $phone;   // NOWE PRZYPISANIE
        $this->id = $id;
        $this->averageRating = $averageRating;
        $this->reviewCount = $reviewCount;
        $this->locations = [];
        $this->reviews = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    // NOWA METODA
    public function getPhone(): string
    {
        return $this->phone;
    }

    // NOWA METODA
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function getReviewCount(): ?int
    {
        return $this->reviewCount;
    }

    public function getLocations(): array
    {
        return $this->locations;
    }

    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function setReviews(array $reviews): void
    {
        $this->reviews = $reviews;
    }
}