<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TNull;

require_once __DIR__ . '/../type/TNull.php';
require_once 'LOp.php';

class LNotEmpty extends LOp {

    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        
        if ($evaluatedValue1->size() == 0) {
            $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
            return $evaluatedValue2->size() != 0 ? $evaluatedValue2 : new TNull();
        } else {
            return $evaluatedValue1;
        }
    }
}

?>
