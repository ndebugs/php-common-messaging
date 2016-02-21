<?php

namespace com\debugs\messaging\lang;

use ReflectionClass;

require_once 'LangArgumentsOutOfRangeException.php';
require_once 'LangEvaluationException.php';

abstract class LObject {

    const ESCAPE = '\\';
    const PREFIX_NAMESPACE = 'L';
    const PREFIX = '[';
    const SUFFIX = ']';
    const FUNCTION_DELIMETER = ' ';
    const PARAMETER_PREFIX = ':';
    const PARAMETER_DELIMETER = ',';

    private $minArgs;
    private $maxArgs;
    
    public function __construct() {
        $args = func_get_args();
        $size = count($args);
        if ($size == 1 && is_array($args[0])) {
            $args = $args[0];
            $size = count($args);
        }
        $this->init($args);
        if ($size < $this->minArgs ||
                ($this->maxArgs > -1 && $size > $this->maxArgs)) {
            throw new LangArgumentsOutOfRangeException($this,
                    $size, $this->minArgs, $this->maxArgs);
        }
    }

    protected abstract function init($args = null);
    
    public abstract function evaluate($message, $key, $value);

    public function getMinArgs() {
        return $this->minArgs;
    }
    
    protected function setMinArgs($minArgs) {
        $this->minArgs = $minArgs;
    }
    
    public function getMaxArgs() {
        return $this->maxArgs;
    }
    
    protected function setMaxArgs($maxArgs) {
        $this->maxArgs = $maxArgs;
    }
    
    protected function setArgsRange($min, $max) {
        $this->minArgs = $min;
        $this->maxArgs = $max;
    }
    
    protected function setFixedArgs($value) {
        $this->minArgs = $value;
        $this->maxArgs = $value;
    }
    
    public abstract function params();

    public function escape($value) {
        foreach (self::reservedChars() as $reservedChar) {
            $value = str_replace($reservedChar, self::ESCAPE . $reservedChar, $value);
        }
        return $value;
    }

    public function name() {
        $reflector = new ReflectionClass($this);
        return lcfirst(substr($reflector->getShortName(), 1));
    }

    public function fullName() {
        $reflector = new ReflectionClass($this);
        $namespaces = explode('\\', $reflector->getNamespaceName());

        $result = '';
        foreach ($namespaces as $namespace) {
            if (strpos($namespace, '_') === 0) {
                $result .= substr($namespace, 1) . self::FUNCTION_DELIMETER;
            }
        }
        $result .= $this->name();
        return $result;
    }

    public function __toString() {
        $result = self::PREFIX . $this->fullName();

        $params = $this->params();
        if ($params) {
            $result .= self::PARAMETER_PREFIX;
            $first = true;
            foreach ($params as $param) {
                if (!$first) {
                    $result .= self::PARAMETER_DELIMETER;
                } else {
                    $first = false;
                }
                $result .= $param;
            }
        }
        $result .= self::SUFFIX;
        return $result;
    }

    public function toVerbosedString() {
        $reflector = new ReflectionClass($this);
        $namespaces = explode('\\', $reflector->getNamespaceName());

        $fullName = '';
        foreach ($namespaces as $namespace) {
            if (strpos($namespace, '_') === 0) {
                $fullName .= substr($namespace, 1) . '\\';
            }
        }
        $fullName .= $reflector->getShortName();
        
        $hashcode = spl_object_hash($this);
        $result = self::PREFIX . $fullName . '@' .
                ltrim(substr($hashcode, 0, 16), '0') . '-' .
                ltrim(substr($hashcode, 16), '0');

        $params = $this->params();
        if ($params) {
            $result .= self::PARAMETER_PREFIX;
            $first = true;
            foreach ($params as $param) {
                if (!$first) {
                    $result .= self::PARAMETER_DELIMETER;
                } else {
                    $first = false;
                }
                $result .= $param instanceof LObject ?
                        $param->toVerbosedString() : $param;
            }
        }
        $result .= self::SUFFIX;
        return $result;
    }

    public static function reservedChars() {
        return array(
            self::ESCAPE,
            self::PREFIX,
            self::SUFFIX,
            self::PARAMETER_PREFIX,
            self::PARAMETER_DELIMETER
        );
    }
}

?>
