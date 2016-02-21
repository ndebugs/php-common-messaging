<?php

namespace com\debugs\messaging\lang\_string;

require_once 'LTrim.php';

class LRTrim extends LTrim {

    protected function execute($value, $chars = null) {
        return $chars != null ? rtrim($value, $chars) : rtrim($value);
    }
}

?>
