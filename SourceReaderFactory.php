<?php
/*

Note: While this isn't technically open to add a new source reader, it does abstract away the need for any class needing a source reader to be ignorant to the details of which one it needs. And it keeps this knowledge in one centralized place. Also we could technically write this in a dynamic approach where we interpolate the $source as the start of the source reader class name, but I feel that is harder to read and understand.

*/

/*

Note: 
I'm sure there's a much more elegant and standard way of including these files.
This is a gap in my php knowledge.

*/

spl_autoload_register(function ($class) {
    include 'services/source_readers/' . $class . '.php';
});

class SourceReaderFactory {
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
