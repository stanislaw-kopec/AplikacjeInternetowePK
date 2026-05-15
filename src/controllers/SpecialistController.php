<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/SpecialistRepository.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../repositories/LocationRepository.php';
require_once __DIR__.'/../models/Specialist.php';
require_once __DIR__.'/../models/Review.php';
require_once __DIR__.'/../models/Location.php';

class SpecialistController extends AppController {

    public function specialists()
    {
        $repository = new SpecialistRepository();
        $specialists = $repository->getAllSpecialists();
        var_dump($specialists);
    }

    public function create()
    {
        if (!$this->isPost()) {
            echo "
                <form method='POST'>
                    <input name='name' placeholder='name' required>
                    <input name='profession' placeholder='profession' required>
                    <input name='phone' placeholder='phone number' required>  <!-- NOWE POLE -->
                    <button type='submit'>create</button>
                </form>
            ";
            return;
        }

        $name = $_POST['name'];
        $profession = $_POST['profession'];
        $phone = $_POST['phone'] ?? '';  // POBIERZ TELEFON
        
        $specialist = new Specialist($name, $profession, $phone);
        
        $repository = new SpecialistRepository();
        $repository->createSpecialist($specialist);
        
        header("Location: /specialists");
    }

    public function assignLocation()
    {
        if (!$this->isPost()) {
            echo "
                <form method='POST'>
                    <input name='specialist_id' placeholder='specialist id'>
                    <input name='location_id' placeholder='location id'>
                    <button type='submit'>assign</button>
                </form>
            ";
            return;
        }

        $specialistId = $_POST['specialist_id'];
        $locationId = $_POST['location_id'];
        
        $repository = new SpecialistRepository();
        $repository->assignLocation($specialistId, $locationId);
        
        echo "Location assigned successfully!";
    }

    public function expertDetail($id = null)
    {
        // Tymczasowo - wyświetl statyczną stronę
        return $this->render("expert-detail");
        
        // TODO: Dynamiczne pobieranie z bazy
        // if ($id === null) {
        //     header("Location: /dashboard");
        //     return;
        // }
        // 
        // $repository = new SpecialistRepository();
        // $specialist = $repository->getSpecialistById((int)$id);
        // return $this->render("expert-detail", ["specialist" => $specialist]);
    }

    /*public function expertDetail($id = null)
    {
        if ($id === null) {
            header("Location: /dashboard");
            return;
        }

        $specialistRepository = new SpecialistRepository();
        $reviewRepository = new ReviewRepository();
        $locationRepository = new LocationRepository();

        $specialist = $specialistRepository->getSpecialistById((int)$id);
        
        if (!$specialist) {
            header("Location: /404");
            return;
        }

        $reviews = $reviewRepository->getReviewsBySpecialistId((int)$id);
        $locations = $locationRepository->getLocationsForSpecialist((int)$id);

        return $this->render("expert-detail", [
            "specialist" => $specialist,
            "reviews" => $reviews,
            "locations" => $locations
        ]);
    }*/

    public function dashboard()
    {
        $specialistRepository = new SpecialistRepository();
        $locationRepository = new LocationRepository();

        $specialists = $specialistRepository->getAllSpecialistsWithRating();
        $locations = $locationRepository->getAllLocations();

        return $this->render("dashboard", [
            "specialists" => $specialists,
            "locations" => $locations
        ]);
    }
}