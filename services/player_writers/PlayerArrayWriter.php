<?php

class PlayerArrayWriter implements PlayerWriter {
    private $playerObject;
    private $player;
    private $playersArray;

    public function __construct($player, $playersObject) {
        $this->playersObject = $playersObject;
        $this->player = $player;
        $this->playersArray = $playersObject->getPlayersArray();
    }

    public function write() {
      $this->playersArray[] = $this->player;
      $this->playersObject->setPlayersArray($this->playersArray);
    }
}

?>