<?php

namespace com\debugs\messaging\type;

require_once 'TBoolean.php';
require_once 'TCollection.php';
require_once 'TNull.php';
require_once 'TNumber.php';
require_once 'TString.php';
require_once 'TypeMismatchException.php';

abstract class TObject {
    
    private $value;
    
    public function __construct() {
        $args = func_get_args();
        $this->value = $this->parse($args);
    }

    public function getValue() {
        return $this->value;
    }

    public abstract function parse($args);
    
    public abstract function size();
    
    public function equals($obj) {
        $objSource = $obj instanceof TObject ? $obj->getValue() : $obj;
        $objValue = $objSource !== null ? (string) $obj : null;
        if ($this->value === null || $objValue === null) {
            return $this->value === $objValue;
        } else {
            return (string) $this === $objValue;
        }
    }

    public static function newInstance($value) {
        if ($value === null) {
            return new TNull();
        } else if (is_bool($value)) {
            return new TBoolean($value);
        } else if (is_int($value)) {
            return new TInteger($value);
        } else if (is_float($value)) {
            return new TDecimal($value);
        } else if (is_array($value)) {
            return TCollection::newInstance($value);
        } else if (is_object($value)) {
            return new TMap($value);
        } else {
            return new TString($value);
        }
    }
}

?>