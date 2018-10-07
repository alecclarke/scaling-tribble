<?php
spl_autoload_register(function ($class) {
    include '../services/player_writers/' . $class . '.php';
});

class PlayerWriterFactory {
  public static function getWriter($source, $player, $playersObject=null, $filename = null) {
    switch ($source) {
        case 'array':
            return new PlayerArrayWriter($player, $playersObject);
            break;
        case 'json':
            return new PlayerJsonWriter($player, $playersObject);
            break;
        case 'file':
            return new PlayerFileWriter($player, $filename);
            break;
        default:
          throw new Exception("No writer support for $source.");
    }
  }
}

?>
