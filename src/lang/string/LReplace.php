<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LObject.php';

class LReplace extends LObject {

    private $source;
    private $pattern;
    private $value;
      
    protected function init($args = null) {
        $this->source = $args[0];
        $this->pattern = $args[1];
        $this->value = $args[2];
        
        $this->setFixedArgs(3);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getPattern() {
        return $this->pattern;
    }

    public function setPattern($pattern) {
        $this->pattern = $pattern;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function evaluate($message, $key, $value) {
        $resultSource = (string) $this->source->evaluate($message, $key, $value);
        $resultPattern = (string) $this->pattern->evaluate($message, $key, $value);
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        
        $result = preg_replace('/' . $resultPattern . '/', $resultValue, $resultSource);
        return new TString($result);
    }
    
    public function params() {
        return array($this->source, $this->pattern, $this->value);
    }
}

?>
