<?php

class Specialist {

    private int $id;
    private ?int $userId;
    private string $name;
    private string $profession;
    private string $phone;
    private string $description;
    private string $bio;
    private string $avatarUrl;
    private int $experienceYears;
    private string $responseTime;
    private ?float $averageRating;
    private ?int $reviewCount;
    private array $locations;
    private array $reviews;
    private array $categories;
    private array $portfolioItems;

    public function __construct(
        string $name,
        string $profession,
        string $phone = '',
        int $id = 0,
        ?float $averageRating = null,
        ?int $reviewCount = null,
        ?int $userId = null,
        string $description = '',
        string $bio = '',
        string $avatarUrl = '',
        int $experienceYears = 0,
        string $responseTime = '< 1 hour'
    ) {
        $this->name = $name;
        $this->profession = $profession;
        $this->phone = $phone;
        $this->id = $id;
        $this->averageRating = $averageRating;
        $this->reviewCount = $reviewCount;
        $this->userId = $userId;
        $this->description = $description;
        $this->bio = $bio;
        $this->avatarUrl = $avatarUrl;
        $this->experienceYears = $experienceYears;
        $this->responseTime = $responseTime;
        $this->locations = [];
        $this->reviews = [];
        $this->categories = [];
        $this->portfolioItems = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public function getExperienceYears(): int
    {
        return $this->experienceYears;
    }

    public function getResponseTime(): string
    {
        return $this->responseTime;
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

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function getPortfolioItems(): array
    {
        return $this->portfolioItems;
    }

    public function setPortfolioItems(array $portfolioItems): void
    {
        $this->portfolioItems = $portfolioItems;
    }
}
