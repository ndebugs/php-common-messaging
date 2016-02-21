<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TNull;

require_once __DIR__ . '/../type/TNull.php';
require_once 'LOp.php';

class LNotNull extends LOp {

    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        
        if ($evaluatedValue1->getValue() === null) {
            $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
            return $evaluatedValue2->getValue() !== null ? $evaluatedValue2 : new TNull();
        } else {
            return $evaluatedValue1;
        }
    }
}

?>
