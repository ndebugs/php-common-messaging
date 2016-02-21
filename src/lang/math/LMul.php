<?php

namespace com\debugs\messaging\lang\_math;

use com\debugs\messaging\lang\LOpNum;
use com\debugs\messaging\type\TDecimal;
use com\debugs\messaging\type\TInteger;

require_once __DIR__ . '/../../type/TDecimal.php';
require_once __DIR__ . '/../../type/TInteger.php';
require_once __DIR__ . '/../LOpNum.php';

class LMul extends LOpNum {
    
    private function execute($value1, $value2) {
        return $value1 * $value2;
    }
    
    protected function executeDecimal($value1, $value2) {
        return new TDecimal($this->execute($value1, $value2));
    }
    
    protected function executeInteger($value1, $value2) {
        return new TInteger($this->execute($value1, $value2));
    }
}

?>
