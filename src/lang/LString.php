<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../type/TString.php';
require_once 'LObject.php';

class LString extends LObject {

    private $value;
    
    protected function init($args = null) {}
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        if ($this->value instanceof LObject) {
            $evaluatedValue = $this->value->evaluate($message, $key, $value);
            return $evaluatedValue instanceof TString ?
                    $evaluatedValue : new TString($evaluatedValue->getValue());
        } else {
            return new TString($this->value);
        }
    }

    public function params() {
        return array(
            $this->value instanceof LString ?
                $this->value : $this->escape($this->value)
        );
    }
    
    public function __toString() {
        return $this->escape($this->value);
    }
    
    public static function newInstance($value) {
        $lang = new LString();
        $lang->setValue($value);
        return $lang;
    }
}

?>
