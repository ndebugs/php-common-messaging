<?php

namespace com\debugs\messaging\type;

require_once 'TObject.php';

class TNull extends TObject {
    
    public function parse($value) {
        return null;
    }
    
    public function size() {
        return 0;
    }
    
    public function __toString() {
        return '';
    }
}

?>