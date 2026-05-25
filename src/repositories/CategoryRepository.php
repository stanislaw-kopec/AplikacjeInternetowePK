<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Category.php';

class CategoryRepository extends Repository {

    public function getAllCategories(): array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM categories ORDER BY name"
        );
        $query->execute();

        $categories = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $categories[] = new Category($data['name'], $data['id']);
        }

        return $categories;
    }
}
