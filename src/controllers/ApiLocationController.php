<?php

require_once 'ApiController.php';
require_once __DIR__.'/../repositories/LocationRepository.php';
require_once __DIR__.'/../models/Location.php';

class ApiLocationController extends ApiController {

    public function list()
    {
        if (!$this->isGet()) {
            $this->jsonError('Method not allowed', 405);
        }

        $repository = new LocationRepository();
        $locations = $repository->getAllLocations();

        $locationsArray = [];
        foreach ($locations as $location) {
            $locationsArray[] = [
                'id' => $location->getId(),
                'city' => $location->getCity()
            ];
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $locationsArray
        ]);
    }

    public function create()
    {
        $this->requireAuth();

        if (!$this->isPost()) {
            $this->jsonError('Method not allowed', 405);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['city'])) {
            $this->jsonError('City is required', 400);
        }

        $location = new Location($input['city']);
        $repository = new LocationRepository();
        $repository->createLocation($location);

        $this->jsonResponse([
            'success' => true,
            'message' => 'Location created successfully'
        ], 201);
    }
}