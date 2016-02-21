<?php

namespace com\debugs\messaging\lang\_map;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TList;
use com\debugs\messaging\type\TMap;

require_once __DIR__ . '/../../type/TList.php';
require_once __DIR__ . '/../../type/TMap.php';
require_once __DIR__ . '/../LObject.php';

class LKeys extends LObject {

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
        $parsedValue = $evaluatedValue instanceof TMap ?
                $evaluatedValue : new TMap($evaluatedValue->getValue());
        $resultValue = $parsedValue->getValue();
        
        $result = array();
        foreach ($resultValue as $k => $v) {
            $result[] = $k;
        }
        return new TList($result);
    }

    public function params() {
        return array($this->value);
    }
}

?>
