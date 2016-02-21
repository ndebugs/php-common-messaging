<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TNumber;

require_once __DIR__ . '/../type/TNumber.php';
require_once 'LObject.php';

class LInt extends LObject {

    private $value;
    private $fromBase;
    private $toBase;
    
    protected function init($args = null) {
        $this->value = $args[0];
        $this->fromBase = $args[1];
        $this->toBase = $args[2];
        
        $this->setArgsRange(1, 3);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getFromBase() {
        return $this->fromBase;
    }

    public function setFromBase($fromBase) {
        $this->fromBase = $fromBase;
    }

    public function getToBase() {
        return $this->toBase;
    }

    public function setToBase($toBase) {
        $this->toBase = $toBase;
    }

    public function evaluate($message, $key, $value) {
        $resultValue = $this->value->evaluate($message, $key, $value)->getValue();
        
        if ($this->fromBase) {
            $evaluatedFromBase = $this->fromBase->evaluate($message, $key, $value);
            $parsedFromBase = $evaluatedFromBase instanceof TNumber ?
                    $evaluatedFromBase : new TInteger($evaluatedFromBase->getValue());
            $resultFromBase = $parsedFromBase->integerValue();
            
            if ($this->toBase) {
                $evaluatedToBase = $this->toBase->evaluate($message, $key, $value);
                $parsedToBase = $evaluatedToBase instanceof TNumber ?
                        $evaluatedToBase : new TInteger($evaluatedToBase->getValue());
                $resultToBase = $parsedToBase->integerValue();
                
                return new TInteger($resultValue, $resultFromBase, $resultToBase);
            } else {
                return new TInteger($resultValue, $resultFromBase);
            }
        } else {
            return new TInteger($resultValue);
        }
    }

    public function params() {
        return $this->toBase ?
                array($this->value, $this->fromBase, $this->toBase) :
                $this->fromBase ?
                array($this->value, $this->fromBase) :
                array($this->value);
    }
}

?>
