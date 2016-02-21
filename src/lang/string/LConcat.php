<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LVarArgs;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TString.php';
require_once __DIR__ . '/../LVarArgs.php';

class LConcat extends LVarArgs {

    protected function init($args = null) {}
    
    public function evaluate($message, $key, $value) {
        $result = '';
        foreach ($this->getValues() as $v) {
            $result .= $v->evaluate($message, $key, $value);
        }
        return new TString($result);
    }
    
    public function __toString() {
        $result = '';
        foreach ($this->getValues() as $value) {
            $result .= $value;
        }
        return $result;
    }
    
    public static function newInstance($values) {
        $lang = new LConcat();
        $lang->setValues($values);
        return $lang;
    }
}

?>
