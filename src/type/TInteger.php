<?php

namespace com\debugs\messaging\type;

require_once 'TNumber.php';

class TInteger extends TNumber {
    
    private $base;
    
    public function parse($args) {
        $value = $args[0];
        $fromBase = $args[1] ? $args[1] : 10;
        $this->base = $args[2] ? $args[2] : 10;
        
        if ($value === null) {
            return null;
        } else if (is_float($value)) {
            return (integer) $value;
        } else if (is_int($value)) {
            return $value;
        } else {
            $valueString = (string) $value;
            $pattern = $this->patternFromBase($fromBase);
            if (preg_match('/^'. $pattern .'$/', $valueString)) {
                return intval($valueString, $fromBase);
            } else {
                throw new TypeMismatchException($this, $value);
            }
        }
    }
    
    public function decimalValue() {
        return (float) $this->getValue();
    }
    
    public function integerValue() {
        return $this->getValue();
    }
    
    private function patternFromBase($base) {
        switch ($base) {
            case 2:
                return '(0|(-{0,1}[1][1-0]*))';
            case 8:
                return '(0|(-{0,1}[1-7][0-7]*))';
            case 10:
                return '(0|(-{0,1}[1-9]\d*))(\.\d+)?';
            case 16:
                return '(0|(-{0,1}[1-9a-f][0-9a-f]*))';
        }
    }
    
    public function __toString() {
        return $this->getValue() && $this->base != 10 ?
                base_convert($this->getValue(), 10, $this->base) :
                (string) $this->getValue();
    }
}

?>