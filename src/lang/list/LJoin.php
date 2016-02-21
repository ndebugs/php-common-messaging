<?php

namespace com\debugs\messaging\lang\_list;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TList;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TList.php';
require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LObject.php';

class LJoin extends LObject {

    private $value;
    private $delimeter;
      
    protected function init($args = null) {
        $this->value = $args[0];
        $this->delimeter = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getDelimeter() {
        return $this->delimeter;
    }

    public function setDelimeter($delimeter) {
        $this->delimeter = $delimeter;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        $parsedValue = $evaluatedValue instanceof TList ?
                $evaluatedValue : new TList($evaluatedValue->getValue());
        $resultValue = $parsedValue->getValue();
        
        $resultDelimeter = (string) $this->delimeter->evaluate($message, $key, $value);
        
        $result = implode($resultDelimeter, $resultValue);
        return new TString($result);
    }
    
    public function params() {
        return array($this->value, $this->delimeter);
    }
}

?>
