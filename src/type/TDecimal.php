<?php

namespace com\debugs\messaging\type;

require_once 'TNumber.php';

class TDecimal extends TNumber {
    
    public function parse($args) {
        $value = $args[0];
        
        if ($value === null) {
            return null;
        } else if (is_int($value)) {
            return (float) $value;
        } else if (is_float($value)) {
            return $value;
        } else {
            $valueString = (string) $value;
            if (preg_match('/^(0|(-{0,1}[1-9]\d*))(\.\d+)?$/', $valueString)) {
                return floatval($valueString);
            } else {
                throw new TypeMismatchException($this, $value);
            }
        }
    }
    
    public function decimalValue() {
        return $this->getValue();
    }
    
    public function integerValue() {
        return (integer) $this->getValue();
    }
    
    public function __toString() {
        $result = (string) $this->getValue();
        if ($result && !strpos($result, '.')) {
            return $result . '.0';
        } else {
            return $result;
        }
    }
}

?>