<?php
class PlayerViewFactory {
  public static function getView($isCLI, $players) {
    if ($isCLI) {
        return new PlayerCLIView($players);
    } else {
        return new PlayerHTMLView($players);
    }
  }
}

?>
