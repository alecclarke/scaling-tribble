<?php

class PlayerCLIView implements PlayerView {
    private $players;

    public function __construct($players) {
        $this->players = $players;
    }

    public function display() {
        echo "Current Players: \n";
        foreach ($this->players as $player) {

            echo "\tName: $player->name\n";
            echo "\tAge: $player->age\n";
            echo "\tSalary: $player->salary\n";
            echo "\tJob: $player->job\n\n";
        }
    }
}

?>
