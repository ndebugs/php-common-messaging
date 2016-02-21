<?php

namespace com\debugs\messaging\lang;

require_once 'LObject.php';

abstract class LOp extends LObject {

    private $value1;
    private $value2;
    
    protected function init($args = null) {
        $this->value1 = $args[0];
        $this->value2 = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getValue1() {
        return $this->value1;
    }

    public function setValue1($value1) {
        $this->value1 = $value1;
    }

    public function getValue2() {
        return $this->value2;
    }

    public function setValue2($value2) {
        $this->value2 = $value2;
    }
    
    public function params() {
        return array(
            $this->value1,
            $this->value2
        );
    }
}

?>
