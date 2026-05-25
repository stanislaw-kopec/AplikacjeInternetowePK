<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Specialist.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../models/Category.php';
require_once __DIR__.'/../models/PortfolioItem.php';

class SpecialistRepository extends Repository {

    public function addPortfolioItem(PortfolioItem $item): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO portfolio_items (specialist_id, title, image_url) 
             VALUES (:specialist_id, :title, :image_url)"
        );

        $specialistId = $item->getSpecialistId();
        $title = $item->getTitle();
        $imageUrl = $item->getImageUrl();

        $query->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);
        $query->execute();
    }

    public function getAllSpecialists(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM specialists ORDER BY id"
        );
        $query->execute();

        $specialists = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $specialists[] = $this->buildSpecialist($data);
        }

        return $specialists;
    }

    public function getAllSpecialistsWithRating(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT s.*,
                    ROUND(AVG(r.rating)::numeric, 1) as avg_rating,
                    COUNT(r.id) as review_count
             FROM specialists s
             LEFT JOIN reviews r ON s.id = r.specialist_id
             GROUP BY s.id
             ORDER BY avg_rating DESC NULLS LAST, s.id"
        );
        $query->execute();

        $specialists = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $specialists[] = $this->buildSpecialist($data, true);
        }

        return $specialists;
    }

    public function getSpecialistById(int $id): ?Specialist
    {
        $query = $this->database->connect()->prepare(
            "SELECT s.*,
                    ROUND(AVG(r.rating)::numeric, 1) as avg_rating,
                    COUNT(r.id) as review_count
             FROM specialists s
             LEFT JOIN reviews r ON s.id = r.specialist_id
             WHERE s.id = :id
             GROUP BY s.id"
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->buildSpecialist($data, true);
    }

    public function getSpecialistByUserId(int $userId): ?Specialist
    {
        $query = $this->database->connect()->prepare(
            "SELECT s.*,
                    ROUND(AVG(r.rating)::numeric, 1) as avg_rating,
                    COUNT(r.id) as review_count
             FROM specialists s
             LEFT JOIN reviews r ON s.id = r.specialist_id
             WHERE s.user_id = :user_id
             GROUP BY s.id"
        );

        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->buildSpecialist($data, true);
    }

    public function createSpecialist(Specialist $specialist): int
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO specialists(user_id, name, profession, phone, description, bio, avatar_url, experience_years, response_time)
             VALUES (:user_id, :name, :profession, :phone, :description, :bio, :avatar_url, :experience_years, :response_time)
             RETURNING id"
        );

        $userId = $specialist->getUserId();
        $name = $specialist->getName();
        $profession = $specialist->getProfession();
        $phone = $specialist->getPhone();
        $description = $specialist->getDescription();
        $bio = $specialist->getBio();
        $avatarUrl = $specialist->getAvatarUrl();
        $experienceYears = $specialist->getExperienceYears();
        $responseTime = $specialist->getResponseTime();

        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':profession', $profession, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':bio', $bio, PDO::PARAM_STR);
        $query->bindParam(':avatar_url', $avatarUrl, PDO::PARAM_STR);
        $query->bindParam(':experience_years', $experienceYears, PDO::PARAM_INT);
        $query->bindParam(':response_time', $responseTime, PDO::PARAM_STR);
        $query->execute();

        return (int)$query->fetchColumn();
    }

    public function updateSpecialist(Specialist $specialist): void
    {
        $query = $this->database->connect()->prepare(
            "UPDATE specialists
             SET name = :name,
                 profession = :profession,
                 phone = :phone,
                 description = :description,
                 bio = :bio,
                 avatar_url = :avatar_url,
                 experience_years = :experience_years,
                 response_time = :response_time
             WHERE id = :id"
        );

        $id = $specialist->getId();
        $name = $specialist->getName();
        $profession = $specialist->getProfession();
        $phone = $specialist->getPhone();
        $description = $specialist->getDescription();
        $bio = $specialist->getBio();
        $avatarUrl = $specialist->getAvatarUrl();
        $experienceYears = $specialist->getExperienceYears();
        $responseTime = $specialist->getResponseTime();

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':profession', $profession, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':bio', $bio, PDO::PARAM_STR);
        $query->bindParam(':avatar_url', $avatarUrl, PDO::PARAM_STR);
        $query->bindParam(':experience_years', $experienceYears, PDO::PARAM_INT);
        $query->bindParam(':response_time', $responseTime, PDO::PARAM_STR);
        $query->execute();
    }

    public function assignLocation(int $specialistId, int $locationId): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO specialist_locations(specialist_id, location_id)
             VALUES (:specialistId, :locationId)
             ON CONFLICT (specialist_id, location_id) DO NOTHING"
        );

        $query->bindParam(':specialistId', $specialistId, PDO::PARAM_INT);
        $query->bindParam(':locationId', $locationId, PDO::PARAM_INT);
        $query->execute();
    }

    public function syncCategories(int $specialistId, array $categoryIds): void
    {
        $connection = $this->database->connect();
        $delete = $connection->prepare("DELETE FROM specialist_categories WHERE specialist_id = :specialist_id");
        $delete->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
        $delete->execute();

        $insert = $connection->prepare(
            "INSERT INTO specialist_categories(specialist_id, category_id)
             VALUES (:specialist_id, :category_id)
             ON CONFLICT (specialist_id, category_id) DO NOTHING"
        );

        foreach ($categoryIds as $categoryId) {
            $categoryId = (int)$categoryId;
            $insert->bindParam(':specialist_id', $specialistId, PDO::PARAM_INT);
            $insert->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $insert->execute();
        }
    }

    public function getLocationsForSpecialist(int $specialistId): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT l.id, l.city
             FROM locations l
             INNER JOIN specialist_locations sl ON l.id = sl.location_id
             WHERE sl.specialist_id = :id
             ORDER BY l.city"
        );

        $query->bindParam(':id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $locations = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $locations[] = new Location($data['city'], $data['id']);
        }

        return $locations;
    }

    public function getCategoriesForSpecialist(int $specialistId): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT c.id, c.name
             FROM categories c
             INNER JOIN specialist_categories sc ON c.id = sc.category_id
             WHERE sc.specialist_id = :id
             ORDER BY c.name"
        );

        $query->bindParam(':id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $categories = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $categories[] = new Category($data['name'], $data['id']);
        }

        return $categories;
    }

    public function getPortfolioForSpecialist(int $specialistId): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM portfolio_items WHERE specialist_id = :id ORDER BY id"
        );

        $query->bindParam(':id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $items = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $items[] = new PortfolioItem(
                $data['specialist_id'],
                $data['title'],
                $data['image_url'],
                $data['id']
            );
        }

        return $items;
    }

    private function buildSpecialist(array $data, bool $withRelations = false): Specialist
    {
        $specialist = new Specialist(
            $data['name'],
            $data['profession'],
            $data['phone'] ?? '',
            $data['id'],
            isset($data['avg_rating']) && $data['avg_rating'] !== null ? (float)$data['avg_rating'] : null,
            isset($data['review_count']) ? (int)$data['review_count'] : null,
            isset($data['user_id']) ? (int)$data['user_id'] : null,
            $data['description'] ?? '',
            $data['bio'] ?? '',
            $data['avatar_url'] ?? '',
            isset($data['experience_years']) ? (int)$data['experience_years'] : 0,
            $data['response_time'] ?? '< 1 hour'
        );

        if ($withRelations) {
            $specialist->setLocations($this->getLocationsForSpecialist($specialist->getId()));
            $specialist->setCategories($this->getCategoriesForSpecialist($specialist->getId()));
            $specialist->setPortfolioItems($this->getPortfolioForSpecialist($specialist->getId()));
        }

        return $specialist;
    }
}
