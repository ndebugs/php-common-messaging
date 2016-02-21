<?php

namespace com\debugs\messaging\type;

require_once 'TObject.php';

class TString extends TObject {
    
    public function parse($args) {
        $value = $args[0];
        
        return $value !== null ? (string) $value : null;
    }
    
    public function size() {
        return strlen($this->getValue());
    }
    
    public function __toString() {
        return (string) $this->getValue();
    }
}

?>