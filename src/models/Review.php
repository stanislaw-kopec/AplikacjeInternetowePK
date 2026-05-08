<?php

class Review {

    private int $id;
    private int $specialistId;
    private string $author;
    private int $rating;
    private string $comment;

    public function __construct(
        int $specialistId,
        string $author,
        int $rating,
        string $comment,
        int $id = 0
    ) {
        $this->specialistId = $specialistId;
        $this->author = $author;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getSpecialistId(): int {
        return $this->specialistId;
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
}