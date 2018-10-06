<?php
/*

Note: 
I'm sure there's a much more elegant and standard way of including these files.
This is a gap in my php knowledge.

*/
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
        //We're only using this if we're storing players as an array.
        $this->playersArray = [];

        //We'll only use this one if we're storing players as a JSON string
        $this->playerJsonString = null;
    }

    /**
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading players in 'file' mode.
     * @return string json
     */
    function readPlayers($source, $filename = null) {
        $sourceReader = SourceReaderFactory::getReader($source, $filename);
        $playerData = $sourceReader->read();

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
        switch ($source) {
            case 'array':
                $this->playersArray[] = $player;
                break;
            case 'json':
                $players = [];
                if ($this->playerJsonString) {
                    $players = json_decode($this->playerJsonString);
                }
                $players[] = $player;
                $this->playerJsonString = json_encode($player);
                break;
            case 'file':
                $players = json_decode($this->getPlayerDataFromFile($filename));
                if (!$players) {
                    $players = [];
                }
                $players[] = $player;
                file_put_contents($filename, json_encode($players));
                break;
        }
    }

    function getPlayerDataFromFile($filename) {
        $file = file_get_contents($filename);
        return $file;
    }

    function display($isCLI, $source, $filename = null) {

        $players = $this->readPlayers($source, $filename);

        if ($isCLI) {
            $view = new PlayerCLIView($players);
            $view->display();
        } else {
            $view = new PlayerHTMLView($players);
            $view->display();
        }
    }

}

$playersObject = new PlayersObject();

$playersObject->display(php_sapi_name() === 'cli', 'array');

?>