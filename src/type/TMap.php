<?php

namespace com\debugs\messaging\type;

require_once 'TCollection.php';

class TMap extends TCollection {
    
    public function getValueAt($key) {
        $value = $this->getValue();
        return $value[$key];
    }
    
    public function parse($args) {
        $value = $args[0];
        
        if ($value === null) {
            return null;
        } else if (is_array($value)) {
            return $value;
        } else if (is_object($value)) {
            return (array) $value;
        } else {
            throw new TypeMismatchException($this, $value);
        }
    }
    
    public function __toString() {
        if ($this->getValue()) {
            $result = '';
            foreach ($this->getValue() as $key => $value) {
                if ($result) {
                    $result .= ',';
                }
                $result .= $key . ':' . $value;
            }
            return '{' . $result . '}';
        } else {
            return '';
        }
    }
}

?>