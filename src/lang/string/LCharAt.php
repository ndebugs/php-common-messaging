<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TCharacter;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TNumber;

require_once __DIR__ . '/../../type/TCharacter.php';
require_once __DIR__ . '/../../type/TNumber.php';
require_once __DIR__ . '/../LObject.php';

class LCharAt extends LObject {

    private $source;
    private $index;
    
    protected function init($args = null) {
        $this->source = $args[0];
        $this->index = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getIndex() {
        return $this->index;
    }

    public function setIndex($index) {
        $this->index = $index;
    }

    public function evaluate($message, $key, $value) {
        $resultSource = (string) $this->source->evaluate($message, $key, $value);
        
        $evaluatedIndex = $this->index->evaluate($message, $key, $value);
        $parsedIndex = $evaluatedIndex instanceof TNumber ?
                $evaluatedIndex : new TInteger($evaluatedIndex->getValue());

        $result = $resultSource[$parsedIndex->integerValue()];
        return new TCharacter($result);
    }

    public function params() {
        return array($this->source, $this->index);
    }
}

?>
