<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../../type/TBoolean.php';
require_once __DIR__ . '/../LObject.php';

class LContains extends LObject {

    private $source;
    private $value;
      
    protected function init($args = null) {
        $this->source = $args[0];
        $this->value = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        $resultSource = (string) $this->source->evaluate($message, $key, $value);
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        
        $result = strpos($resultSource, $resultValue);
        return new TBoolean($result !== false);
    }
    
    public function params() {
        return array($this->source, $this->value);
    }
}

?>
