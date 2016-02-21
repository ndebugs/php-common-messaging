<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TInteger;

require_once __DIR__ . '/../../type/TInteger.php';
require_once __DIR__ . '/../LObject.php';

class LLength extends LObject {

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
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        
        $result = strlen($resultValue);
        return new TInteger($result);
    }
    
    public function params() {
        return array($this->value);
    }
}

?>
