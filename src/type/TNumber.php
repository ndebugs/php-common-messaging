<?php

namespace com\debugs\messaging\type;

require_once 'TDecimal.php';
require_once 'TInteger.php';
require_once 'TObject.php';

abstract class TNumber extends TObject {
    
    public abstract function decimalValue();

    public abstract function integerValue();

    public function size() {
        return $this->getValue();
    }
    
    public static function newInstance($value) {
        if ($value == null || is_int($value)) {
            return new TInteger($value);
        } else if (is_float($value)) {
            return new TDecimal($value);
        } else {
            $valueString = (string) $value;
            return strpos($valueString, '.') ?
                new TDecimal($valueString) :
                new TInteger($valueString);
        }
    }
}

?>