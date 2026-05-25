<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../models/Review.php';

class ReviewController extends AppController {

    public function create($specialistId = null)
{
    $this->requireRole('User');

    if (!$this->isPost()) {
        // Można zostawić pusty lub przekierować – formularz jest w widoku
        header("Location: /dashboard");
        return;
    }

    $specialistId = (int)$_POST['specialist_id'];
    $user = $this->getCurrentUser();
    $author = $user->getEmail();               // zawsze email zalogowanego
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'] ?? '';
    $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;

    $review = new Review(
        $specialistId,
        $author,
        $rating,
        $comment,
        0,
        $user->getId(),
        null,
        $categoryId
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