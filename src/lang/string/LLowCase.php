<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LObject.php';

class LLowCase extends LObject {

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
        
        $result = strtolower($resultValue);
        return new TString($result);
    }
    
    public function params() {
        return array($this->value);
    }
}

?>
