<?php

namespace com\debugs\messaging\lang\_string;

use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\type\TCharacter;
use com\debugs\messaging\type\TInteger;
use com\debugs\messaging\type\TNumber;
use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../../type/TCharacter.php';
require_once __DIR__ . '/../../type/TNumber.php';
require_once __DIR__ . '/../../type/TString.php';

class LPad extends LObject {

    private $value;
    private $character;
    private $length;
      
    protected function init($args = null) {
        $this->value = $args[0];
        $this->character = $args[1];
        $this->length = $args[2];
        
        $this->setFixedArgs(3);
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getCharacter() {
        return $this->character;
    }

    public function setCharacter($character) {
        $this->character = $character;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }
    
    public function evaluate($message, $key, $value) {
        $resultValue = (string) $this->value->evaluate($message, $key, $value);
        
        $evaluatedCharacter = $this->character->evaluate($message, $key, $value);
        $parsedCharacter = $evaluatedCharacter instanceof TCharacter ?
                $evaluatedCharacter : new TCharacter($evaluatedCharacter->getValue());
        $resultCharacter = (string) $parsedCharacter;
        
        $evaluatedLength = $this->length->evaluate($message, $key, $value);
        $parsedLength = $evaluatedLength instanceof TNumber ?
                $evaluatedLength : new TInteger($evaluatedLength->getValue());
        $resultLength = $parsedLength->integerValue();

        $type = 0;
        if ($resultLength > -1) {
            $type = STR_PAD_RIGHT;
        } else {
            $resultLength = -$resultLength;
            $type = STR_PAD_LEFT;
        }
        
        $result = str_pad($resultValue, $resultLength, $resultCharacter, $type);
        return new TString($result);
    }
    
    public function params() {
        return array($this->value, $this->character, $this->length);
    }
}

?>
