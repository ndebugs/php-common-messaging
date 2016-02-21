<?php

namespace com\debugs\messaging;

use Exception;

class LangNonEscapedCharacterException extends Exception {
    
    public function __construct($index, $value) {
        parent::__construct('\'' . $value . '\' is not an escaped character, at index ' . $index . '.', 0, null);
    }
    
}

?>
