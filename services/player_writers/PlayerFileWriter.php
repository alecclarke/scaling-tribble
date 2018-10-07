<?php

class PlayerFileWriter implements PlayerWriter {
    private $player;
    private $filename;

    public function __construct($player, $filename) {
        $this->player = $player;
        $this->filename = $filename;
    }

    public function write() {
      $players = json_decode($this->getPlayerDataFromFile());
      
      if (!$players) {
          $players = [];
      }

      $players[] = $this->player;
      file_put_contents($this->filename, json_encode($players));
    }

    private function getPlayerDataFromFile() {
      $file = file_get_contents($this->filename);
      return $file;
    }
}

?>