<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Review.php';

class ReviewRepository extends Repository {

    public function getReviewsBySpecialistId(int $specialistId): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM reviews WHERE specialist_id = :specialist_id ORDER BY id DESC"
        );

        $query->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $reviews = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $review) {
            $reviews[] = new Review(
                $review['specialist_id'],
                $review['author'],
                $review['rating'],
                $review['comment'],
                $review['id']
            );
        }

        return $reviews;
    }

    public function createReview(Review $review): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO reviews (specialist_id, author, rating, comment) 
             VALUES (:specialist_id, :author, :rating, :comment)"
        );

        $specialistId = $review->getSpecialistId();
        $author = $review->getAuthor();
        $rating = $review->getRating();
        $comment = $review->getComment();

        $query->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':comment', $comment, PDO::PARAM_STR);

        $query->execute();
    }

    public function getAverageRating(int $specialistId): float
    {
        $query = $this->database->connect()->prepare(
            "SELECT AVG(rating) as avg_rating, COUNT(*) as count 
             FROM reviews WHERE specialist_id = :specialist_id"
        );

        $query->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result['avg_rating'] ? round($result['avg_rating'], 1) : 0;
    }

    public function getReviewCount(int $specialistId): int
    {
        $query = $this->database->connect()->prepare(
            "SELECT COUNT(*) as count FROM reviews WHERE specialist_id = :specialist_id"
        );

        $query->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return (int)$result['count'];
    }
}