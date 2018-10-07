<?php

class PlayerJsonWriter implements PlayerWriter {
    private $playerObject;
    private $player;
    private $playerJsonString;

    public function __construct($player, $playersObject) {
        $this->playersObject = $playersObject;
        $this->player = $player;
        $this->playerJsonString = $playersObject->getPlayerJsonString();
    }

    public function write() {
      $players = [];
      
      if ($this->playerJsonString) {
          $players = json_decode($this->playerJsonString);
      }

      $players[] = $this->player;
      $this->playersObject->setPlayerJsonString(json_encode($players));
    }
}

?>