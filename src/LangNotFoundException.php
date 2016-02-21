<?php

namespace com\debugs\messaging;

use Exception;

class LangNotFoundException extends Exception {
    
    public function __construct($alias) {
        parent::__construct('Invalid lang name \'' . $alias . '\'.', 0, null);
    }
    
}

?>
