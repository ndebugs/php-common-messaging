<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LObject.php';

class LTrim extends LObject {

    private $value;
    private $characters;
    
    protected function init($args = null) {
        $this->value = $args[0];
        $this->characters = $args[1];
        
        $this->setArgsRange(1, 2);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    protected function execute($value, $chars = null) {
        return $chars ? trim($value, $chars) : trim($value);
    }
    
    public function evaluate($message, $key, $value) {
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        $resultChars = $this->characters ?
                (string) $this->characters->evaluate($message, $key, $value) : null;
        
        $result = $this->execute($resultValue, $resultChars);
        return new TString($result);
    }

    public function params() {
        return $this->characters ?
                array($this->value, $this->characters) :
                array($this->value);
    }
}

?>
