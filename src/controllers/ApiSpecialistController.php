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
            'data' => $specialists
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
            'data' => $specialist,
            'reviews' => $reviews
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
            $input['phone'] ?? ''
        );

        $repository = new SpecialistRepository();
        $repository->createSpecialist($specialist);

        $this->jsonResponse([
            'success' => true,
            'message' => 'Specialist created successfully'
        ], 201);
    }
}