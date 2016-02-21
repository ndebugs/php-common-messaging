<?php

namespace com\debugs\messaging;

use com\debugs\messaging\lang\_string\LConcat;
use com\debugs\messaging\lang\LObject;
use com\debugs\messaging\lang\LString;

require_once 'LangBuilder.php';
require_once 'LangParserException.php';
require_once 'LangNonEscapedCharacterException.php';
require_once 'lang/LString.php';
require_once 'lang/string/LConcat.php';

class LangParser {

    const STATE_DONE = -1;
    const STATE_NONE = 0;
    const STATE_FUNCTION = 1;
    const STATE_ARGUMENTS = 2;
    
    private $data;
    private $offset;
    private $state;
    private $parent;
    
    public function __construct($data, $offset = 0, $parent = null) {
        $this->data= $data;
        $this->offset = $offset;
        $this->parent = $parent;
    }
    
    public function getOffset() {
        return $this->offset;
    }
    
    public function setOffset($offset) {
        $this->offset = $offset;
    }
    
    protected function updateState($state) {
        switch ($state) {
            case self::STATE_NONE:
                if ($this->state == self::STATE_NONE) {
                    throw new LangParserException($this->offset, $this->data[$this->offset], LObject::PREFIX);
                }
                break;
            case self::STATE_ARGUMENTS:
                if ($this->state != self::STATE_FUNCTION) {
                    throw new LangParserException($this->offset, $this->data[$this->offset], LObject::PREFIX);
                }
                break;
            case self::STATE_FUNCTION:
            case self::STATE_DONE:
                if ($this->state != self::STATE_NONE) {
                    $c = $this->offset < strlen($this->data) ? $this->data[$this->offset] : '';
                    throw new LangParserException($this->offset, $c, LObject::SUFFIX);
                }
                break;
        }
        $this->state = $state;
    }
    
    public function isEscapedChar($c) {
        foreach (LObject::reservedChars() as $reservedChar) {
            if ($reservedChar == $c) {
                return true;
            }
        }
        return false;
    }
    
    private function parseLang($name) {
        $this->offset++;
        $builder = new LangBuilder($name);
        while ($this->state == self::STATE_ARGUMENTS) {
            $parser = new LangParser($this->data, $this->offset, $this);
            $value = $parser->parse();
            $builder->addArgument($value);
            $this->offset = $parser->getOffset();
        }
        return $builder->build();
    }
    
    public function parseNext() {
        $isEscaped = false;
        $tempString = null;
        $length = strlen($this->data);
        for (; $this->offset < $length; $this->offset++) {
            $c = $this->data[$this->offset];
            if (!$isEscaped) {
                if ($c == LObject::ESCAPE) {
                    $isEscaped = true;
                    continue;
                } else if ($c == LObject::PREFIX) {
                    $this->updateState(self::STATE_FUNCTION);
                    break;
                } else if ($c == LObject::SUFFIX) {
                    if ($this->parent != null && $this->state == self::STATE_NONE) {
                        $this->updateState(self::STATE_DONE);
                        $this->parent->updateState(self::STATE_NONE);
                        break;
                    } else {
                        $this->updateState(self::STATE_NONE);
                        return $this->parseLang($tempString);
                    }
                } else if ($c == LObject::PARAMETER_PREFIX) {
                    $this->updateState(self::STATE_ARGUMENTS);
                    return $this->parseLang($tempString);
                } else if ($c == LObject::PARAMETER_DELIMETER) {
                    if ($this->parent != null) {
                        $this->updateState(self::STATE_DONE);
                        break;
                    } else {
                        throw new LangParserException($this->offset, $c, LObject::PARAMETER_PREFIX);
                    }
                }
            } else if ($this->isEscapedChar($c)) {
                $isEscaped = false;
            } else {
                throw new LangNonEscapedCharacterException($this->offset, $c);
            }
            $tempString .= $c;
        }
        
        if ($this->offset == $length) {
            $this->updateState(self::STATE_DONE);
            if ($this->parent != null) {
                $this->parent->setOffset($this->offset);
                $this->parent->updateState(self::STATE_DONE);
            }
        } else {
            $this->offset++;
        }
        
        return strlen($tempString) > 0 ? LString::newInstance($tempString): null;
    }

    public function parse() {
        $list = array();
        while ($this->state != self::STATE_DONE) {
            $lang = $this->parseNext();
            if ($lang != null) {
                $list[] = $lang;
            }
        }
        $listSize = count($list);
        if ($listSize > 1) {
            return LConcat::newInstance($list);
        } else {
            return $listSize == 0 ? LString::newInstance("") : $list[0];
        }
    }
}

?>
