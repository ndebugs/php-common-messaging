<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LObject.php';

class LNot extends LObject {

    private $value;
    
    protected function init($args = null) {
        $this->value = $args[0];
        
        $this->setArgsRange(1, 1);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        $parsedValue = $evaluatedValue instanceof TBoolean ?
                $evaluatedValue : new TBoolean($evaluatedValue->getValue());
        return new TBoolean(!$parsedValue->getValue());
    }

    public function params() {
        return array($this->value);
    }
}

?>
