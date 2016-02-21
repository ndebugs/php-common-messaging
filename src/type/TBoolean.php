<?php

namespace com\debugs\messaging\type;

require_once 'TObject.php';

class TBoolean extends TObject {
    
    const TRUE_VALUE = 'true';
    const FALSE_VALUE = 'false';
    
    public function parse($args) {
        $value = $args[0];
        
        if (is_bool($value)) {
            return $value;
        } else {
            throw new TypeMismatchException($this, $value);
        }
    }
    
    public function size() {
        return $this->getValue() ? 1 : 0;
    }
    
    public function __toString() {
        return $this->getValue() !== null ?
                $this->getValue() ? self::TRUE_VALUE : self::FALSE_VALUE : '';
    }
}

?>