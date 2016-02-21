<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TDecimal;

require_once __DIR__ . '/../type/TDecimal.php';
require_once 'LObject.php';

class LDec extends LObject {

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
        
        return $evaluatedValue instanceof TDecimal ?
                $evaluatedValue : new TDecimal($evaluatedValue->getValue());
    }

    public function params() {
        return array($this->value);
    }
}

?>
