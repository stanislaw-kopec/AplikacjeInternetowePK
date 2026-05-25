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
        $this->requireRole('Specialist');

        $repository = new SpecialistRepository();
        $existingSpecialist = $repository->getSpecialistByUserId($_SESSION['user_id']);

        if ($existingSpecialist) {
            header("Location: /expert-detail/" . $existingSpecialist->getId());
            return;
        }

        if (!$this->isPost()) {
            echo "
                <form method='POST'>
                    <input name='name' placeholder='name' required>
                    <input name='profession' placeholder='profession' required>
                    <input name='phone' placeholder='phone number' required>
                    <button type='submit'>create</button>
                </form>
            ";
            return;
        }

        $specialist = new Specialist(
            $_POST['name'],
            $_POST['profession'],
            $_POST['phone'] ?? '',
            0,
            null,
            null,
            $_SESSION['user_id']
        );

        $id = $repository->createSpecialist($specialist);

        header("Location: /expert-detail/{$id}");
    }

    public function assignLocation()
    {
        $this->requireRole('Specialist');

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

        $repository = new SpecialistRepository();
        $repository->assignLocation((int)$_POST['specialist_id'], (int)$_POST['location_id']);

        echo "Location assigned successfully!";
    }

    public function expertDetail($id = null)
    {
        if ($id === null) {
            header("Location: /dashboard");
            return;
        }

        $specialistRepository = new SpecialistRepository();
        $reviewRepository = new ReviewRepository();
        $specialist = $specialistRepository->getSpecialistById((int)$id);

        if (!$specialist) {
            include 'public/views/404.html';
            return;
        }

        return $this->render("expert-detail", [
            "specialistId" => (int)$id,
            "specialist" => $specialist,
            "reviews" => $reviewRepository->getReviewsBySpecialistId((int)$id)
        ]);
    }

    public function dashboard()
    {
        $specialistRepository = new SpecialistRepository();
        $locationRepository = new LocationRepository();

        return $this->render("dashboard", [
            "specialists" => $specialistRepository->getAllSpecialistsWithRating(),
            "locations" => $locationRepository->getAllLocations()
        ]);
    }
}
