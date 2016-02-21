<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LOp.php';

class LNeq extends LOp {

    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
        
        $result = !$evaluatedValue1->equals($evaluatedValue2);
        return new TBoolean($result);
    }
}

?>
