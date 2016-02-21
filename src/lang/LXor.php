<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LOp.php';

class LXor extends LOp {

    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        $parsedValue1 = $evaluatedValue1 instanceof TBoolean ?
                $evaluatedValue1 : new TBoolean($evaluatedValue1->getValue());
        
        $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
        $parsedValue2 = $evaluatedValue2 instanceof TBoolean ?
                $evaluatedValue2 : new TBoolean($evaluatedValue2->getValue());

        return new TBoolean($parsedValue1->getValue() xor $parsedValue2->getValue());
    }
}

?>
