<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LOpNum.php';

class LGt extends LOpNum {

    protected function executeDecimal($value1, $value2) {
        return new TBoolean($value1 > $value2);
    }
    
    protected function executeInteger($value1, $value2) {
        return $this->executeDecimal($value1, $value2);
    }
}

?>
