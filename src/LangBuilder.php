<?php

namespace com\debugs\messaging;

use com\debugs\messaging\lang\LObject;

require_once 'LangNotFoundException.php';

class LangBuilder {
    
    private $name;
    private $arguments;
    
    public function __construct($name) {
        $this->name = $name;
        $this->arguments = array();
    }
    
    public function addArgument($argument) {
        $this->arguments[] = $argument;
    }
    
    public function build() {
        $names = split(LObject::FUNCTION_DELIMETER, $this->name);
        $nameSize = count($names);
        $className = LObject::PREFIX_NAMESPACE . $names[$nameSize - 1];
        $className[1] = chr(ord($className[1]) - 32);
        $names[$nameSize - 1] = $className;
        
        $path = __DIR__ . '/lang/' . join('/', $names) . '.php';
        if (!file_exists($path)) {
            throw new LangNotFoundException($this->name);
        }
        $namespace = 'com\\debugs\\messaging\\lang\\';
        if ($nameSize > 1) {
            for ($i = 0; $i < $nameSize - 1; $i++) {
                $namespace .= '_' . $names[$i] . '\\';
            }
        }
        $classFullname = $namespace . $className;
        
        require_once $path;
        $result = new $classFullname($this->arguments);
        if (get_class($result) != $classFullname) {
            throw new LangNotFoundException($this->name);
        }
        return $result;
    }
}

?>
