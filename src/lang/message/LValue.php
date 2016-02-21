<?php

namespace com\debugs\messaging\lang\_message;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TObject;

require_once __DIR__ . '/../../type/TObject.php';
require_once __DIR__ . '/../LObject.php';

class LValue extends LObject {

    protected function init($args = null) {}
    
    public function evaluate($message, $key, $value) {
        return TObject::newInstance($value);
    }

    public function params() {
        return null;
    }
}

?>
