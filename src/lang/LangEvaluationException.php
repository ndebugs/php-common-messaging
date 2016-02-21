<?php

namespace com\debugs\messaging\lang;

use Exception;

class LangEvaluationException extends Exception {
    
    public function __construct(LObject $lang, $message) {
        if ($message) {
            $message = ' ' . $message;
        }
        parent::__construct('Evaluation error on lang \'' .  $lang->fullName() . '\'.' . $message, null, null);
    }
    
}

?>
