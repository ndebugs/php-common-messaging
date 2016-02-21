<?php

namespace com\debugs\messaging\type;

require_once 'TCollection.php';

class TList extends TCollection {
    
    public function getValueAt($key) {
        $value = $this->getValue();
        return $value[$key];
    }
    
    public function parse($args) {
        $value = $args[0];
        
        if ($value === null) {
            return null;
        } else if (is_array($value)) {
            $i = 0;
            foreach ($value as $k => $v) {
                if ($k !== $i++) {
                    throw new TypeMismatchException($this, $value);
                }
            }
            return $value;
        } else {
            throw new TypeMismatchException($this, $value);
        }
    }
    
    public function __toString() {
        if ($this->getValue()) {
            $result = '';
            foreach ($this->getValue() as $key => $value) {
                if ($key) {
                    $result .= ',';
                }
                $result .= $value;
            }
            return '[' . $result . ']';
        } else {
            return '';
        }
    }
}

?>