<?php

require_once 'ApiController.php';
require_once __DIR__.'/../repositories/SpecialistRepository.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../repositories/LocationRepository.php';

class ApiSpecialistController extends ApiController {

    public function list()
    {
        if (!$this->isGet()) {
            $this->jsonError('Method not allowed', 405);
        }

        $repository = new SpecialistRepository();
        $specialists = $repository->getAllSpecialistsWithRating();

        $this->jsonResponse([
            'success' => true,
            'data' => array_map([$this, 'specialistToArray'], $specialists)
        ]);
    }

    public function getById($id = null)
    {
        if (!$this->isGet()) {
            $this->jsonError('Method not allowed', 405);
        }

        if ($id === null) {
            $this->jsonError('Specialist ID is required', 400);
        }

        $repository = new SpecialistRepository();
        $specialist = $repository->getSpecialistById((int)$id);

        if (!$specialist) {
            $this->jsonError('Specialist not found', 404);
        }

        $reviewRepository = new ReviewRepository();
        $reviews = $reviewRepository->getReviewsBySpecialistId((int)$id);

        $this->jsonResponse([
            'success' => true,
            'data' => $this->specialistToArray($specialist),
            'reviews' => array_map([$this, 'reviewToArray'], $reviews)
        ]);
    }

    public function create()
    {
        $this->requireAuth();

        if (!$this->isPost()) {
            $this->jsonError('Method not allowed', 405);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['name']) || !isset($input['profession'])) {
            $this->jsonError('Name and profession are required', 400);
        }

        $specialist = new Specialist(
            $input['name'],
            $input['profession'],
            $input['phone'] ?? '',
            0,
            null,
            null,
            $_SESSION['user_id'],
            $input['description'] ?? '',
            $input['bio'] ?? '',
            $input['avatar_url'] ?? '',
            (int)($input['experience_years'] ?? 0),
            $input['response_time'] ?? '< 1 hour'
        );

        $repository = new SpecialistRepository();
        $repository->createSpecialist($specialist);

        $this->jsonResponse([
            'success' => true,
            'message' => 'Specialist created successfully'
        ], 201);
    }

    private function specialistToArray(Specialist $specialist): array
    {
        return [
            'id' => $specialist->getId(),
            'name' => $specialist->getName(),
            'profession' => $specialist->getProfession(),
            'phone' => $specialist->getPhone(),
            'description' => $specialist->getDescription(),
            'bio' => $specialist->getBio(),
            'avatar_url' => $specialist->getAvatarUrl(),
            'experience_years' => $specialist->getExperienceYears(),
            'response_time' => $specialist->getResponseTime(),
            'average_rating' => $specialist->getAverageRating(),
            'review_count' => $specialist->getReviewCount(),
            'locations' => array_map(fn($location) => [
                'id' => $location->getId(),
                'city' => $location->getCity()
            ], $specialist->getLocations()),
            'categories' => array_map(fn($category) => [
                'id' => $category->getId(),
                'name' => $category->getName()
            ], $specialist->getCategories())
        ];
    }

    private function reviewToArray(Review $review): array
    {
        return [
            'id' => $review->getId(),
            'specialist_id' => $review->getSpecialistId(),
            'user_id' => $review->getUserId(),
            'author' => $review->getAuthor(),
            'rating' => $review->getRating(),
            'comment' => $review->getComment(),
            'created_at' => $review->getCreatedAt()
        ];
    }
}
