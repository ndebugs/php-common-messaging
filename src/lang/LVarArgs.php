<?php

namespace com\debugs\messaging\lang;

require_once 'LObject.php';

abstract class LVarArgs extends LObject {

    private $values;
    
    protected function init($args = null) {
        $this->values = $args;
    }
    
    public function getValues() {
        return $this->values;
    }

    public function setValues($values) {
        $this->values = $values;
    }
    
    public function params() {
        return $this->values;
    }
}

?>
