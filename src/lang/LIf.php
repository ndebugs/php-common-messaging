<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LObject.php';

class LIf extends LObject {

    private $condition;
    private $trueValue;
    private $falseValue;

    protected function init($args = null) {
        $this->condition = $args[0];
        $this->trueValue = $args[1];
        $this->falseValue = $args[2];
        
        $this->setFixedArgs(3);
    }
    
    public function getCondition() {
        return $this->condition;
    }

    public function setCondition($condition) {
        $this->condition = $condition;
    }

    public function getTrueValue() {
        return $this->trueValue;
    }

    public function setTrueValue($trueValue) {
        $this->trueValue = $trueValue;
    }

    public function getFalseValue() {
        return $this->falseValue;
    }

    public function setFalseValue($falseValue) {
        $this->falseValue = $falseValue;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedCondition = $this->condition->evaluate($message, $key, $value);
        $parsedCondition = $evaluatedCondition instanceof TBoolean ?
                $evaluatedCondition : new TBoolean($evaluatedCondition->getValue());
        
        return $parsedCondition->getValue() ?
                $this->trueValue->evaluate($message, $key, $value) :
                $this->falseValue->evaluate($message, $key, $value);
    }
    
    public function params() {
        return array($this->condition, $this->trueValue, $this->falseValue);
    }
}

?>
