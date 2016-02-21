<?php

namespace com\debugs\messaging\lang\_list;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TList;

require_once __DIR__ . '/../../type/TInteger.php';
require_once __DIR__ . '/../../type/TList.php';
require_once __DIR__ . '/../LObject.php';

class LSize extends LObject {

    private $value;
      
    protected function init($args = null) {
        $this->value = $args[0];
        
        $this->setFixedArgs(1);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function evaluate($message, $key, $value) {
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        $parsedValue = $evaluatedValue instanceof TList ?
                $evaluatedValue : new TList($evaluatedValue->getValue());
        
        $result = $parsedValue->size();
        return new TInteger($result);
    }
    
    public function params() {
        return array($this->value);
    }
}

?>
