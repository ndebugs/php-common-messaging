<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TBoolean;

require_once __DIR__ . '/../type/TBoolean.php';
require_once 'LVarArgs.php';

class LAnd extends LVarArgs {

    protected function init($args = null) {
        parent::init($args);
        
        $this->setArgsRange(2, -1);
    }
    
    public function evaluate($message, $key, $value) {
        foreach ($this->getValues() as $v) {
            $evaluatedValue = $v->evaluate($message, $key, $value);
            $parsedValue = $evaluatedValue instanceof TBoolean ?
                $evaluatedValue : new TBoolean($evaluatedValue->getValue());
            if ($parsedValue->getValue() !== true) {
                return new TBoolean(false);
            }
        }
        return new TBoolean(true);
    }
}

?>
