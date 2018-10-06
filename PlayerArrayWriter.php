<?php

class PlayerArrayWriter implements PlayerWriter {
    private $playerObject;
    private $player;

    public function __construct($player, $playersObject) {
        $this->playersObject = $playersObject;
        $this->player = $player;
    }

    public function write() {
      $this->playersObject->appendPlayersArray($this->player);
    }
}

?>