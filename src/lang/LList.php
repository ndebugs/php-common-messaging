<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TList;

require_once __DIR__ . '/../type/TList.php';
require_once 'LVarArgs.php';

class LList extends LVarArgs {

    protected function init($args = null) {
        parent::init($args);
        
        $this->setArgsRange(0, -1);
    }
    
    public function evaluate($message, $key, $value) {
        $result = array();
        foreach ($this->getValues() as $v) {
            $evaluatedValue = $v->evaluate($message, $key, $value);
            $result[] = $evaluatedValue->getValue();
        }
        return new TList($result);
    }
}

?>
