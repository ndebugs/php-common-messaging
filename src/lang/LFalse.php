<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LObject.php';

class LFalse extends LObject {

    protected function init($args = null) {}
    
    public function evaluate($message, $key, $value) {
        return new TBoolean(false);
    }

    public function params() {
        return null;
    }
}

?>
