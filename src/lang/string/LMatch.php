<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../../type/TBoolean.php';
require_once __DIR__ . '/../LObject.php';

class LMatch extends LObject {

    private $value;
    private $pattern;
      
    protected function init($args = null) {
        $this->value = $args[0];
        $this->pattern = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getPattern() {
        return $this->pattern;
    }

    public function setPattern($pattern) {
        $this->pattern = $pattern;
    }

    public function evaluate($message, $key, $value) {
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        $resultPattern = (string) $this->pattern->evaluate($message, $key, $value);
        
        $result = preg_match('/' . $resultPattern . '/', $resultValue);
        return new TBoolean($result === 1);
    }
    
    public function params() {
        return array($this->value, $this->pattern);
    }
}

?>
