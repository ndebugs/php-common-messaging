<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TNumber;

require_once __DIR__ . '/../type/TNumber.php';
require_once 'LOp.php';

abstract class LOpNum extends LOp {

    protected abstract function executeDecimal($value1, $value2);
    
    protected abstract function executeInteger($value1, $value2);
    
    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        $parsedValue1 = $evaluatedValue1 instanceof TNumber ?
                $evaluatedValue1 : TNumber::newInstance($evaluatedValue1->getValue());
        $resultValue1 = $parsedValue1->getValue();
        
        $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
        $parsedValue2 = $evaluatedValue2 instanceof TNumber ?
                $evaluatedValue2 : TNumber::newInstance($evaluatedValue2->getValue());
        $resultValue2 = $parsedValue2->getValue();
        
        if (is_float($resultValue1) || is_float($resultValue2)) {
            return $this->executeDecimal($resultValue1, $resultValue2);
        } else {
            return $this->executeInteger($resultValue1, $resultValue2);
        }
    }
}

?>
