<?php

namespace com\debugs\messaging\lang;

use com\debugs\messaging\type\TString;

require_once __DIR__ . '/../type/TString.php';
require_once 'LObject.php';

class LDateTime extends LObject {

    const SECOND = 's';
    const MINUTE = 'm';
    const HOUR = 'h';
    const DAY = 'D';
    const MONTH = 'M';
    const YEAR = 'Y';
    
    private $pattern;
    private $difference;
    
    protected function init($args = null) {
        $this->pattern = $args[0];
        $this->difference = $args[1];
        
        $this->setArgsRange(1, 2);
    }
    
    public function getPattern() {
        return $this->pattern;
    }

    public function getDifference() {
        return $this->difference;
    }

    public function setPattern($pattern) {
        $this->pattern = $pattern;
    }

    public function setDifference($difference) {
        $this->difference = $difference;
    }

    private function translateDifferenceUnit($unit) {
        switch ($unit) {
            case self::SECOND: return 'second';
            case self::MINUTE: return 'minute';
            case self::HOUR: return 'hour';
            case self::DAY: return 'day';
            case self::MONTH: return 'month';
            case self::YEAR: return 'year';
        }
        throw new LangEvaluationException($this, 'Unknown difference unit \'' . $unit . '\'.');
    }
    
    public function evaluate($message, $key, $value) {
        $resultPattern = (string) $this->pattern->evaluate($message, $key, $value);
        
        $result = null;
        if ($this->difference) {
            $resultDifference = (string) $this->difference->evaluate($message, $key, $value);
            
            $lastIndex = strlen($resultDifference) - 1;
            $value = substr($resultDifference, 0, $lastIndex);
            $unit = $resultDifference[$lastIndex];
            
            $timeString = $value . ' ' . $this->translateDifferenceUnit($unit);
            $result = date($resultPattern, strtotime($timeString));
        } else {
            $result = date($resultPattern);
        }
        
        return new TString($result);
    }

    public function params() {
        return $this->difference ?
                array($this->pattern, $this->difference) :
                array($this->pattern);
    }
}

?>
