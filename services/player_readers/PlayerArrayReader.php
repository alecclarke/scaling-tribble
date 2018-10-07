<?php

class PlayerArrayReader implements PlayerReader {
    public function read() {
        $players = [];

        $jonas = new \stdClass();
        $jonas->name = 'Jonas Valenciunas';
        $jonas->age = 26;
        $jonas->job = 'Center';
        $jonas->salary = '4.66m';
        $players[] = $jonas;

        $kyle = new \stdClass();
        $kyle->name = 'Kyle Lowry';
        $kyle->age = 32;
        $kyle->job = 'Point Guard';
        $kyle->salary = '28.7m';
        $players[] = $kyle;

        $kawhi = new \stdClass();
        $kawhi->name = 'Kawhi Leonard';
        $kawhi->age = 27;
        $kawhi->job = 'Shooting Guard';
        $kawhi->salary = '17.64m';
        $players[] = $kawhi;

        $jakob = new \stdClass();
        $jakob->name = 'Jakob Poeltl';
        $jakob->age = 22;
        $jakob->job = 'Center';
        $jakob->salary = '2.704m';
        $players[] = $jakob;

        return $players;
    }
}

?>
