<?php

class PortfolioItem {

    private int $id;
    private int $specialistId;
    private string $title;
    private string $imageUrl;

    public function __construct(int $specialistId, string $title, string $imageUrl, int $id = 0)
    {
        $this->specialistId = $specialistId;
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSpecialistId(): int
    {
        return $this->specialistId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }
}
