<?php
spl_autoload_register(function ($class) {
    include '../services/player_readers/' . $class . '.php';
});

class PlayerReaderFactory {
  public static function getReader($source, $filename = null) {
    switch ($source) {
        case 'array':
            return new PlayerArrayReader();
            break;
        case 'json':
            return new PlayerJsonReader();
            break;
        case 'file':
            return new PlayerFileReader($filename);
            break;
        default:
          throw new Exception("No reader support for $source.");
    }
  }
}

?>
