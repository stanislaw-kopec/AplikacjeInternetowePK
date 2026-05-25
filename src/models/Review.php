<?php

class Review {

    private int $id;
    private int $specialistId;
    private ?int $userId;
    private string $author;
    private int $rating;
    private string $comment;
    private ?string $createdAt;

    public function __construct(
        int $specialistId,
        string $author,
        int $rating,
        string $comment,
        int $id = 0,
        ?int $userId = null,
        ?string $createdAt = null
    ) {
        $this->specialistId = $specialistId;
        $this->author = $author;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->id = $id;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getSpecialistId(): int {
        return $this->specialistId;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getComment(): string {
        return $this->comment;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }
}
