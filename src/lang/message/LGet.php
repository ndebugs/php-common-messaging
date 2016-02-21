<?php

namespace com\debugs\messaging\lang\_message;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TMap;
use com\debugs\messaging\type\TObject;

require_once __DIR__ . '/../../type/TObject.php';
require_once __DIR__ . '/../LObject.php';

class LGet extends LObject {

    private $key;
    
    protected function init($args = null) {
        $this->key = $args[0];
        
        $this->setFixedArgs(1);
    }
    
    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function evaluate($message, $key, $value) {
        $parsedMessage = $message instanceof TMap ?
                $message : new TMap($message);
        
        $resultKey = (string) $this->key->evaluate($message, $key, $value);

        $result = $parsedMessage->getValueAt($resultKey);
        return TObject::newInstance($result);
    }

    public function params() {
        return array($this->key);
    }
}

?>
