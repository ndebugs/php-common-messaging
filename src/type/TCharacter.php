<?php

namespace com\debugs\messaging\type;

require_once 'TObject.php';

class TCharacter extends TObject {
    
    public function parse($args) {
        $value = $args[0];
        
        if ($value === null) {
            return null;
        } else {
            $valueString = (string) $value;
            if (strlen($valueString) <= 1) {
                return $valueString;
            } else {
                throw new TypeMismatchException($this, $value);
            }
        }
    }
    
    public function size() {
        return strlen($this->getValue());
    }
    
    public function __toString() {
        return (string) $this->getValue();
    }
}

?>