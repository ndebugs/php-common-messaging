<?php

namespace com\debugs\messaging\lang;

use Exception;

class LangArgumentsOutOfRangeException extends Exception {
    
    public function __construct(LObject $lang, $size, $min, $max = 0) {
        $detail = 'min: ' . $min;
        if ($max > -1) {
            $detail .= ' and max: ' . $max;
        }
        parent::__construct('Arguments out of range for lang \'' .  $lang->fullName() . '\' with size: ' . $size . ', expected ' . $detail, null, null);
    }
    
}

?>
