<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Specialist.php';
require_once __DIR__.'/../models/Location.php';

class SpecialistRepository extends Repository {

    public function getAllSpecialists(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM specialists"
        );
        $query->execute();

        $specialists = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $specialist) {
            $specialists[] = new Specialist(
                $specialist['name'],
                $specialist['profession'],
                $specialist['phone'] ?? '',  // DODAJ POLE
                $specialist['id']
            );
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
             ORDER BY avg_rating DESC NULLS LAST"
        );
        $query->execute();

        $specialists = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $specialist = new Specialist(
                $data['name'],
                $data['profession'],
                $data['phone'] ?? '',  // DODAJ POLE
                $data['id'],
                $data['avg_rating'] ? (float)$data['avg_rating'] : null,
                (int)$data['review_count']
            );
            
            $specialist->setLocations($this->getLocationsForSpecialist($data['id']));
            $specialists[] = $specialist;
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

        $specialist = new Specialist(
            $data['name'],
            $data['profession'],
            $data['phone'] ?? '',  // DODAJ POLE
            $data['id'],
            $data['avg_rating'] ? (float)$data['avg_rating'] : null,
            (int)$data['review_count']
        );

        $specialist->setLocations($this->getLocationsForSpecialist($id));

        return $specialist;
    }

    public function createSpecialist(Specialist $specialist): void
    {
        // ZAKTUALIZOWANE ZAPYTANIE
        $query = $this->database->connect()->prepare(
            "INSERT INTO specialists(name, profession, phone) 
             VALUES (:name, :profession, :phone)"
        );

        $name = $specialist->getName();
        $profession = $specialist->getProfession();
        $phone = $specialist->getPhone();

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':profession', $profession, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);  // NOWY BIND
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

    public function getLocationsForSpecialist(int $specialistId): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT l.id, l.city
             FROM locations l
             INNER JOIN specialist_locations sl ON l.id = sl.location_id
             WHERE sl.specialist_id = :id"
        );

        $query->bindParam(':id', $specialistId, PDO::PARAM_INT);
        $query->execute();

        $locations = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $locations[] = new Location($data['city'], $data['id']);
        }

        return $locations;
    }
}