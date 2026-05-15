<?php

require_once 'AppController.php';

require_once __DIR__.'/../repositories/LocationRepository.php';
require_once __DIR__.'/../models/Location.php';

class LocationController extends AppController {

    public function locations()
    {
        $repository = new LocationRepository();

        $locations = $repository->getAllLocations();

        var_dump($locations);
    }

    public function create()
    {
        if (!$this->isPost()) {

            echo "
                <form method='POST'>
                    <input name='city'>
                    <button type='submit'>
                        create
                    </button>
                </form>
            ";

            return;
        }

        $city = $_POST['city'];

        $location = new Location($city);

        $repository = new LocationRepository();

        $repository->createLocation($location);

        header("Location: /locations");
    }
}