<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Profile.php';

class ProfileRepository extends Repository {

    public function getProfileByUserId(int $userId): ?Profile
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM profiles WHERE user_id = :user_id"
        );

        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Profile(
            $data['user_id'],
            $data['username'],
            $data['id']
        );
    }

    public function createProfile(Profile $profile): void
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO profiles (user_id, username) 
             VALUES (:user_id, :username)
             ON CONFLICT (user_id) DO UPDATE 
             SET username = :username"
        );

        $userId = $profile->getUserId();
        $username = $profile->getUsername();

        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
    }
}