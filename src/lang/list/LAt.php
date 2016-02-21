<?php

namespace com\debugs\messaging\lang\_list;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TList;
use com\debugs\messaging\type\TNumber;
use com\debugs\messaging\type\TObject;

require_once __DIR__ . '/../../type/TObject.php';
require_once __DIR__ . '/../LObject.php';

class LAt extends LObject {

    private $source;
    private $index;
    
    protected function init($args = null) {
        $this->source = $args[0];
        $this->index = $args[1];
        
        $this->setFixedArgs(2);
    }
    
    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getIndex() {
        return $this->index;
    }

    public function setIndex($index) {
        $this->index = $index;
    }

    public function evaluate($message, $key, $value) {
        $evaluatedSource = $this->source->evaluate($message, $key, $value);
        $parsedSource = $evaluatedSource instanceof TList ?
                $evaluatedSource : new TList($evaluatedSource->getValue());
        
        $evaluatedIndex = $this->index->evaluate($message, $key, $value);
        $parsedIndex = $evaluatedIndex instanceof TNumber ?
                $evaluatedIndex : new TInteger($evaluatedIndex->getValue());
        $resultIndex = $parsedIndex->integerValue();

        $result = $parsedSource->getValueAt($resultIndex);
        return TObject::newInstance($result);
    }

    public function params() {
        return array($this->source, $this->index);
    }
}

?>
