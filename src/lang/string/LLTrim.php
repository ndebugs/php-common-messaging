<?php

namespace com\debugs\messaging\lang\_string;

require_once 'LTrim.php';

class LLTrim extends LTrim {

    protected function execute($value, $chars = null) {
        return $chars != null ? ltrim($value, $chars) : ltrim($value);
    }
}

?>
