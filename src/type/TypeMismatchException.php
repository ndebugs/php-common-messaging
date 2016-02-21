<?php

namespace com\debugs\messaging\type;

use Exception;
use ReflectionClass;

class TypeMismatchException extends Exception {
    
    public function __construct($type, $value) {
        $reflector = new ReflectionClass($type);
        parent::__construct('Type ' . $reflector->getShortName() . ' did not match with value \'' . $value . '\'.', null, null);
    }
    
}

?>
