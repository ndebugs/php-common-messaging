<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TCharacter;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TNumber;

require_once __DIR__ . '/../type/TCharacter.php';
require_once __DIR__ . '/../type/TNumber.php';

class LChar extends LObject {

    private $value;

    protected function init($args = null) {
        $this->value = $args[0];
        
        $this->setFixedArgs(1);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        $resultValue = $evaluatedValue instanceof TNumber ?
                $evaluatedValue : new TInteger($evaluatedValue->getValue());

        $result = chr($resultValue->integerValue());
        return new TCharacter($result);
    }

    public function params() {
        return array($this->value);
    }
}

?>
