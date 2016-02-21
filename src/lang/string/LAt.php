<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TNumber;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TNumber.php';
require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LObject.php';

class LAt extends LObject {

    private $source;
    private $index;
    private $length;
    
    protected function init($args = null) {
        $this->source = $args[0];
        $this->index = $args[1];
        $this->length = $args[2];
        
        $this->setArgsRange(2, 3);
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

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function evaluate($message, $key, $value) {
        $resultSource = (string) $this->source->evaluate($message, $key, $value);
        
        $evaluatedIndex = $this->index->evaluate($message, $key, $value);
        $parsedIndex = $evaluatedIndex instanceof TNumber ?
                $evaluatedIndex : new TInteger($evaluatedIndex->getValue());
        $resultIndex = $parsedIndex->integerValue();
        
        $result = null;
        if ($resultIndex < 0) {
            $resultValueLen = strlen($resultSource);
            
            $resultLength = 0;
            if ($this->length) {
                $evaluatedLength = $this->length->evaluate($message, $key, $value);
                $parsedLength = $evaluatedLength instanceof TNumber ?
                        $evaluatedLength : new TInteger($evaluatedLength->getValue());
                $resultLength = $parsedLength->integerValue();
            } else {
                $resultLength = $resultValueLen + $resultIndex + 1;
            }
            
            $reversedIndex = $resultValueLen - $resultLength + $resultIndex + 1;
            $result = substr($resultSource, $reversedIndex, $resultLength);
        } else if ($this->length) {
            $evaluatedLength = $this->length->evaluate($message, $key, $value);
            $parsedLength = $evaluatedLength instanceof TNumber ?
                    $evaluatedLength : new TInteger($evaluatedLength->getValue());
            $resultLength = $parsedLength->integerValue();
            
            $result = substr($resultSource, $resultIndex, $resultLength);
        } else {
            $result = substr($resultSource, $resultIndex);
        }
        return new TString($result);
    }

    public function params() {
        return $this->length ?
                array($this->source, $this->index, $this->length) :
                array($this->source, $this->index);
    }
}

?>
