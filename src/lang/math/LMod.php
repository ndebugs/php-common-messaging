<?php

namespace com\debugs\messaging\lang\_math;

use com\debugs\messaging\lang\LOpNum;
use com\debugs\messaging\type\TDecimal;
use com\debugs\messaging\type\TInteger;

require_once __DIR__ . '/../../type/TDecimal.php';
require_once __DIR__ . '/../../type/TInteger.php';
require_once __DIR__ . '/../LOpNum.php';

class LMod extends LOpNum {

    protected function executeDecimal($value1, $value2) {
        return new TDecimal($value1 - (integer) $value1 + ($value1 % $value2));
    }
    
    protected function executeInteger($value1, $value2) {
        return new TInteger($value1 % $value2);
    }
}

?>
