<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TEntry;

require_once __DIR__ . '/../type/TEntry.php';
require_once 'LObject.php';

class LEntry extends LObject {

    private $key;
    private $value;
    
    protected function init($args = null) {
        $this->key = $args[0];
        $this->value = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedKey = $this->key->evaluate($message, $key, $value);
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        
        return new TEntry((string) $evaluatedKey->getValue(), $evaluatedValue->getValue());
    }
    
    public function params() {
        return array($this->key, $this->value);
    }
}

?>
