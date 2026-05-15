<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Location.php';

class LocationRepository extends Repository {

    public function getAllLocations(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM locations ORDER BY city"
        );
        $query->execute();

        $locations = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $location) {
            $locations[] = new Location(
                $location['city'],
                $location['id']
            );
        }

        return $locations;
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

    public function createLocation(Location $location): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO locations(city) VALUES (:city)"
        );

        $city = $location->getCity();
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->execute();
    }
}