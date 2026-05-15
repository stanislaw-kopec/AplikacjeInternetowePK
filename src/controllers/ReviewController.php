<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../models/Review.php';

class ReviewController extends AppController {

    public function create($specialistId = null)
    {
        if (!$this->isPost()) {
            echo "
                <form method='POST' action='/review/create/{$specialistId}'>
                    <input type='hidden' name='specialist_id' value='{$specialistId}'>
                    <input name='author' placeholder='Your name' required>
                    <select name='rating' required>
                        <option value='5'>5 stars</option>
                        <option value='4'>4 stars</option>
                        <option value='3'>3 stars</option>
                        <option value='2'>2 stars</option>
                        <option value='1'>1 star</option>
                    </select>
                    <textarea name='comment' placeholder='Your review'></textarea>
                    <button type='submit'>Submit Review</button>
                </form>
            ";
            return;
        }

        $specialistId = $_POST['specialist_id'];
        $author = $_POST['author'];
        $rating = (int)$_POST['rating'];
        $comment = $_POST['comment'] ?? '';

        $review = new Review($specialistId, $author, $rating, $comment);
        
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