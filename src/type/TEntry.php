<?php

namespace com\debugs\messaging\type;

require_once 'TObject.php';

class TEntry extends TObject {
    
    private $key;
    
    public function parse($args) {
        $key = $args[0];
        $value = $args[1];
        
        if ($key === null && $value === null) {
            return null;
        } else if (count($args) == 2) {
            $this->key = $key;
            return $value;
        } else {
            throw new TypeMismatchException($this, $value);
        }
    }
    
    public function getKey() {
        return $this->key;
    }

    public function size() {
        return 1;
    }
    
    public function __toString() {
        return $this->key !== null || $this->getValue() !== null ?
                $this->key . ':' . $this->getValue() : '';
    }
}

?>