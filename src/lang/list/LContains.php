<?php

namespace com\debugs\messaging\lang\_list;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TBoolean;
use com\debugs\messaging\type\TList;

require_once __DIR__ . '/../../type/TBoolean.php';
require_once __DIR__ . '/../../type/TList.php';
require_once __DIR__ . '/../LObject.php';

class LContains extends LObject {

    private $source;
    private $value;
    
    protected function init($args = null) {
        $this->source = $args[0];
        $this->value = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedSource = $this->source->evaluate($message, $key, $value);
        $parsedSource = $evaluatedSource instanceof TList ?
                $evaluatedSource : new TList($evaluatedSource->getValue());
        $resultSource = $parsedSource->getValue();
        
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        
        foreach ($resultSource as $v) {
            if ($evaluatedValue->equals($v)) {
                return new TBoolean(true);
            }
        }
        return new TBoolean(false);
    }

    public function params() {
        return array($this->source, $this->value);
    }
}

?>
