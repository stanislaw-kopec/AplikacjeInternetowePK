<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../models/Review.php';

class ReviewController extends AppController {

    public function create($specialistId = null)
    {
        $this->requireRole('User');

        if (!$this->isPost()) {
            header("Location: /dashboard");
            return;
        }

        $specialistId = (int)$_POST['specialist_id'];
        $user = $this->getCurrentUser();
        $author = $user->getEmail();
        $rating = (int)$_POST['rating'];
        $comment = $_POST['comment'] ?? '';

        $review = new Review(
            $specialistId,
            $author,
            $rating,
            $comment,
            0,
            $user->getId()
        );
        
        $repository = new ReviewRepository();
        $repository->createReview($review);
        
        header("Location: /expert-detail/{$specialistId}");
    }

    public function getSpecialistReviews($specialistId)
    {
        $repository = new ReviewRepository();
        $reviews = $repository->getReviewsBySpecialistId((int)$specialistId);
        
        header('Content-Type: application/json');
        echo json_encode($reviews);
    }
}