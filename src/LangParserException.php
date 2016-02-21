<?php

namespace com\debugs\messaging;

use Exception;

class LangParserException extends Exception {
    
    public function __construct($index, $value, $expected) {
        parent::__construct('Invalid character \'' . $value . '\' at index ' . $index . ', expected \'' . $expected . '\'.', 0, null);
    }
    
}

?>
