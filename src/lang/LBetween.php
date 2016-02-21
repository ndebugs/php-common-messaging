<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;
use com\debugs\messaging\type\TNumber;

require_once __DIR__ . '/../type/TBoolean.php';
require_once __DIR__ . '/../type/TNumber.php';
require_once 'LObject.php';

class LBetween extends LObject {

    private $value;
    private $min;
    private $max;
    
    protected function init($args = null) {
        $this->value = $args[0];
        $this->min = $args[1];
        $this->max = $args[2];
        
        $this->setFixedArgs(3);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getMin() {
        return $this->min;
    }

    public function setMin($min) {
        $this->min = $min;
    }

    public function getMax() {
        return $this->max;
    }

    public function setMax($max) {
        $this->max = $max;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedValue = $this->value->evaluate($message, $key, $value);
        $parsedValue = $evaluatedValue instanceof TNumber ?
                $evaluatedValue : TNumber::newInstance($evaluatedValue->getValue());
        $resultValue = $parsedValue->getValue();
        
        $evaluatedMin = $this->min->evaluate($message, $key, $value);
        $parsedMin = $evaluatedMin instanceof TNumber ?
                $evaluatedMin : TNumber::newInstance($evaluatedMin->getValue());
        
        $evaluatedMax = $this->max->evaluate($message, $key, $value);
        $parsedMax = $evaluatedMax instanceof TNumber ?
                $evaluatedMax : TNumber::newInstance($evaluatedMax->getValue());
        
        $result = $resultValue >= $parsedMin->getValue() &&
                $resultValue <= $parsedMax->getValue();
        return new TBoolean($result);
    }

    public function params() {
        return array($this->value, $this->min, $this->max);
    }
}

?>
