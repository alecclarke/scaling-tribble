<?php
/*

Note: I'm sure there's a much more elegant and standard way of including these files.
This is a gap in my php knowledge (something I'll do some research on).

*/
set_include_path(
    __DIR__ . "/factories" . ":" . __DIR__ . "/views" . ":" . __DIR__ . "/services/player_readers" . ":" . __DIR__ . "/services/player_writers"
);

spl_autoload_register(function ($class) {
    include $class . '.php';
});

interface IReadWritePlayers {
    function readPlayers($source, $filename = null);
    function writePlayer($source, $player, $filename = null);
    function display($isCLI, $course, $filename = null);
}

class PlayersObject implements IReadWritePlayers {

    private $playersArray;

    private $playerJsonString;

    public function __construct() {
        $this->playersArray = [];
        $this->playerJsonString = null;
    }

    /**
     * @param $isCLI boolean for determining if the method is invoked from the command line.
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading from file in 'file' mode
     */
    function display($isCLI, $source, $filename = null) {
        $players = $this->readPlayers($source, $filename);
        $view = PlayerViewFactory::getView($isCLI,$players);
        $view->display();
    }

    /**
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading players in 'file' mode.
     * @return string json
     */
    function readPlayers($source, $filename = null) {
        $reader = PlayerReaderFactory::getReader($source, $filename);
        $playerData = $reader->read();

        if (is_string($playerData)) {
            $playerData = json_decode($playerData);
        }

        return $playerData;
    }

    /**
     * @param $source string Where to write the data. 'json', 'array' or 'file'
     * @param $filename string Only used if we're writing in 'file' mode
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     */
    function writePlayer($source, $player, $filename = null) {
        $writer = PlayerWriterFactory::getWriter($source, $player, $this, $filename);
        $writer->write();
    }

    function getPlayersArray() {
        return $this->playerArray;
    }

    function getPlayerJsonString() {
        return $this->playerJsonString;
    }

    function setPlayersArray($playersArray) {
        $this->playersArray = $playersArray;
    }

    function setPlayerJsonString($playerJsonString) {
        $this->playerJsonString = $playerJsonString;
    }
}

$playersObject = new PlayersObject();

$playersObject->display(php_sapi_name() === 'cli', 'array');

?>