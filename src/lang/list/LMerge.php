<?php

namespace com\debugs\messaging\lang\_list;

use com\debugs\messaging\lang\LOp;
use com\debugs\messaging\type\TList;

require_once __DIR__ . '/../../type/TList.php';
require_once __DIR__ . '/../LOp.php';

class LMerge extends LOp {

    public function evaluate($message, $key, $value) {
        $evaluatedValue1 = $this->getValue1()->evaluate($message, $key, $value);
        $parsedValue1 = $evaluatedValue1 instanceof TList ?
                $evaluatedValue1 : new TList($evaluatedValue1->getValue());
        
        $evaluatedValue2 = $this->getValue2()->evaluate($message, $key, $value);
        $parsedValue2 = $evaluatedValue2 instanceof TList ?
                $evaluatedValue2 : new TList($evaluatedValue2->getValue());

        $result = array_merge($parsedValue1->getValue(), $parsedValue2->getValue());
        return new TList($result);
    }
}

?>
