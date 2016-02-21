<?php

namespace com\debugs\messaging\lang\_map;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TMap;
use com\debugs\messaging\type\TObject;

require_once __DIR__ . '/../../type/TObject.php';
require_once __DIR__ . '/../LObject.php';

class LGet extends LObject {

    private $source;
    private $key;
    
    protected function init($args = null) {
        $this->source = $args[0];
        $this->key = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }
    
    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedSource = $this->source->evaluate($message, $key, $value);
        $parsedSource = $evaluatedSource instanceof TMap ?
                $evaluatedSource : new TMap($evaluatedSource->getValue());
        
        $resultKey = (string) $this->key->evaluate($message, $key, $value);

        $result = $parsedSource->getValueAt($resultKey);
        return TObject::newInstance($result);
    }

    public function params() {
        return array($this->source, $this->key);
    }
}

?>
