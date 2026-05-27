<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/UsersRepository.php';
require_once __DIR__.'/../repositories/SpecialistRepository.php';
require_once __DIR__.'/../repositories/LocationRepository.php';
require_once __DIR__.'/../repositories/ReviewRepository.php';
require_once __DIR__.'/../repositories/CategoryRepository.php';
require_once __DIR__.'/../models/PortfolioItem.php';

class DashboardController extends AppController {

    public function index() {
        $specialistRepository = new SpecialistRepository();
        $locationRepository = new LocationRepository();
        $categoryRepository = new CategoryRepository();

        return $this->render("dashboard", [
            "specialists" => $specialistRepository->getAllSpecialistsWithRating(),
            "locations" => $locationRepository->getAllLocations(),
            "categories" => $categoryRepository->getAllCategories()
        ]);
    }

    public function ildIndex() {
        $this->requireRole('User', 'Specialist');
        $title = "index";
        $usersRepository = new UsersRepository();
        $users = $usersRepository->getUsers();
        return $this->render("index", ["title" => $title, "users" => $users]);
    }

    public function proDashboard() {
        $this->requireRole('Specialist');

        $specialistRepository = new SpecialistRepository();
        $reviewRepository = new ReviewRepository();
        $specialist = $specialistRepository->getSpecialistByUserId($_SESSION['user_id']);

        return $this->render("pro-dashboard", [
            "specialist" => $specialist,
            "reviews" => $specialist ? $reviewRepository->getReviewsBySpecialistId($specialist->getId()) : []
        ]);
    }

    public function profileSettings() {
        $this->requireRole('User', 'Specialist');

        $specialistRepository = new SpecialistRepository();
        $categoryRepository = new CategoryRepository();
        $locationRepository = new LocationRepository();
        $user = $this->getCurrentUser();
        $specialist = $user && $user->getRole() === 'Specialist'
            ? $specialistRepository->getSpecialistByUserId($_SESSION['user_id'])
            : null;

        if ($this->isPost() && $specialist) {
            $updatedSpecialist = new Specialist(
                $_POST['name'] ?? $specialist->getName(),
                $_POST['profession'] ?? $specialist->getProfession(),
                $_POST['phone'] ?? $specialist->getPhone(),
                $specialist->getId(),
                $specialist->getAverageRating(),
                $specialist->getReviewCount(),
                $specialist->getUserId(),
                $_POST['description'] ?? $specialist->getDescription(),
                $_POST['bio'] ?? $specialist->getBio(),
                $_POST['avatar_url'] ?? $specialist->getAvatarUrl(),
                (int)($_POST['experience_years'] ?? $specialist->getExperienceYears()),
                $_POST['response_time'] ?? $specialist->getResponseTime()
            );

            $specialistRepository->updateSpecialist($updatedSpecialist);
            $specialistRepository->syncCategories($specialist->getId(), $_POST['category_ids'] ?? []);
            $specialistRepository->syncLocations($specialist->getId(), $_POST['location_ids'] ?? []);

            if (!empty($_POST['portfolio_title']) && !empty($_POST['portfolio_image_url'])) {
                $portfolioItem = new PortfolioItem(
                    $specialist->getId(),
                    $_POST['portfolio_title'],
                    $_POST['portfolio_image_url']
                );
                $specialistRepository->addPortfolioItem($portfolioItem);
            }

            $_SESSION['flash_message'] = 'Profile updated successfully.';
            header("Location: /pro-dashboard");
            return;
        }

        return $this->render("profile-settings", [
            "specialist" => $specialist,
            "categories" => $categoryRepository->getAllCategories(),
            "locations" => $locationRepository->getAllLocations()   // <-- nowe
        ]);
    }
}