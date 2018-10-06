<?php

class PlayerFileReader implements PlayerSourceReader {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function read() {
        $file = file_get_contents($this->filename);
        return $file;
    }
}

?>