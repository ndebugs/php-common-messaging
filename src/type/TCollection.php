<?php

namespace com\debugs\messaging\type;

require_once 'TList.php';
require_once 'TMap.php';
require_once 'TObject.php';

abstract class TCollection extends TObject {
    
    public abstract function getValueAt($key);
    
    public function size() {
        return count($this->getValue());
    }
    
    public static function newInstance($values) {
        if (is_array($values)) {
            $i = 0;
            foreach ($values as $k => $v) {
                if ($k !== $i++) {
                    return new TMap($values);
                }
            }
            return new TList($values);
        } else {
            return new TMap($values);
        }
    }
}

?>