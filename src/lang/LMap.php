<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TEntry;
use com\debugs\messaging\type\TMap;
use com\debugs\messaging\type\TypeMismatchException;

require_once __DIR__ . '/../type/TEntry.php';
require_once __DIR__ . '/../type/TMap.php';
require_once __DIR__ . '/../type/TypeMismatchException.php';
require_once 'LVarArgs.php';

class LMap extends LVarArgs {
    
    protected function init($args = null) {
        parent::init($args);
        
        $this->setArgsRange(0, -1);
    }
    
    public function evaluate($message, $key, $value) {
        $result = array();
        foreach ($this->getValues() as $v) {
            $evaluatedValue = $v->evaluate($message, $key, $value);
            if ($evaluatedValue instanceof TEntry) {
                $result[$evaluatedValue->getKey()] = $evaluatedValue->getValue();
            } else {
                throw new TypeMismatchException('com\debugs\messaging\type\TEntry', $evaluatedValue);
            }
        }
        return new TMap($result);
    }
}

?>
