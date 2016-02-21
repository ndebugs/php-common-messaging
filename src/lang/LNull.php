<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TNull;

require_once __DIR__ . '/../type/TNull.php';
require_once 'LObject.php';

class LNull extends LObject {

    protected function init($args = null) {}
    
    public function evaluate($message, $key, $value) {
        return new TNull();
    }

    public function params() {
        return null;
    }
}

?>
