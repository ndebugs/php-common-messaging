<?php

use com\debugs\messaging\LangParser;

require_once '../LangParser.php';

class Tester {
    
    private $message;
    private $key;
    private $value;
    
    function __construct($message, $key, $value) {
        $this->message = $message;
        $this->key = $key;
        $this->value = $value;
    }
    
    public function evaluate($title, $statement, $validator) {
        echo $title . "\n";
        echo 'statement          : ' . $statement . "\n";
        $parser = new LangParser($statement);
        $lang = $parser->parse();
        echo 'parsed stat.       : ' . $lang . "\n";
        echo 'parsed stat. detail: ' . $lang->toVerbosedString() . "\n";
        
        $result = (string) $lang->evaluate($this->message, $this->key, $this->value);
        echo 'result             : ' . $result . "\n";
        
        $parserValidator = new LangParser($validator);
        $langValidator = $parserValidator->parse();
        $resultValidator = $langValidator->evaluate(null, null, $result);
        
        if ($resultValidator->getValue() !== true) {
            throw new Exception('Evaluation error.');
        }
        echo "\n";
    }
}

$message = array(
    'msgKey1' => 'Message Value 1',
    'msgKey2' => 'Message Value 2',
    'msgKey3' => 'Message Value 3',
    'list' => array('abc', 'def', 'ghi'),
    'map' => array(
        'a' => '123',
        'b' => '456',
        'c' => '789'
    )
);
$tester = new Tester($message, 'Key', 'Value');

$tester->evaluate('EMPTY STRING',
        '',
        '[isEmpty:[message value]]');

$tester->evaluate('STRING',
        'abc def \\[\\]\\:\\,\\\\',
        '[eq:[message value],abc def \\[\\]\\:\\,\\\\]');

$tester->evaluate('SUBSTRING',
        '[string at:abcdef,0,3] [string at:abcdef,3] [string at:ghijkl,-4] [string at:ghijkl,-1,3]',
        '[eq:[message value],abc def ghi jkl]');

$tester->evaluate('STRING MANIPULATION',
        '[string replace:A1B3C1 1d3e3f,\\[13\\],] [string lowCase:UvW] [string upCase:xYz]',
        '[eq:[message value],ABC def uvw XYZ]');

$tester->evaluate('STRING PAD/UNPAD',
        '[string pad:123,0,-6] [string pad:456,0,6] [string trim:  ABC def  ] [string rTrim:123000,0] [string lTrim:000456,0]',
        '[eq:[message value],000123 456000 ABC def 123 456]');

$tester->evaluate('STRING EVALUATION',
        '[string match:abc123,^\\[a-zA-Z0-9\\]*$] [string match:abc123!@#,^\\[a-zA-Z0-9\\]*$] [string contains:abc,c] [string length:abc]',
        '[eq:[message value],true false true 3]');

$tester->evaluate('CHARACTER',
        '[char:65] [string charAt:abc,1]',
        '[eq:[message value],A b]');

$tester->evaluate('NUMBER',
        '[int:123] [int:ff,16] [int:255,10,16] [dec:123] [dec:0.5]',
        '[eq:[message value],123 255 ff 123.0 0.5]');

$tester->evaluate('CONDITION',
        '[if:[true],TRUE,FALSE] [and:[true],[false]] [or:[true],[false]] [xor:[true],[false]] [not:[true]]',
        '[eq:[message value],TRUE false true true false]');

$tester->evaluate('COMPARATION',
        '[eq:[null],[message get:0]] [neq:[int:1],1] [lt:2,3] [lte:3,2] [gt:3,2] [gte:3,3] [between:5,1,5]',
        '[eq:[message value],true false true false true true true]');

$tester->evaluate('OBJECT EVALUATION',
        '[isNull:] [isEmpty:]',
        '[eq:[message value],false true]');

$tester->evaluate('OBJECT COMPARATION',
        '[notNull:[null],] [notNull:abc,[null]] [notEmpty:[int:0],def] [notEmpty:[null],]',
        '[eq:[message value], abc def ]');

$tester->evaluate('MATH OPERATION',
        '[math sum:1,1] [math sub:3,1] [math mul:2,2] [math div:10,3.0] [math mod:10,3]',
        '[eq:[message value],2 2 4 3.3333333333333 1]');

$tester->evaluate('MATH COMPARATION',
        '[math min:1,0] [math min:1,1.5] [math max:1,0] [math max:1,1.5]',
        '[eq:[message value],0 1.0 1 1.5]');

$tester->evaluate('RANDOM',
        '[math random:1,9]',
        '[between:[message value],1,9]');

$tester->evaluate('DATETIME',
        '[dateTime:d-m-Y] [dateTime:d-m-Y,-1D]',
        '[eq:[message value],' . date('d-m-Y') . " " . date('d-m-Y', strtotime('-1 day')) . ']');

$tester->evaluate('LIST',
        '[list at:[list merge:[list:0,1,2],[string split:3\\,4\\,5,\\,]],3] [list join:[message get:list],-] [list contains:[message get:list],abc] [list size:[message get:list]]',
        '[eq:[message value],3 abc-def-ghi true 3]');

$tester->evaluate('MAP',
        '[map get:[map:[entry:key1,value1],[entry:key2,value2],[entry:key3,value3]],key2] [map contains:[message get:map],123] [map size:[message get:map]] [map keys:[message get:map]] [map values:[message get:map]]',
        '[eq:[message value],value2 true 3 \\[a\\,b\\,c\\] \\[123\\,456\\,789\\]]');

$tester->evaluate('MESSAGE',
        '[message get:msgKey2] [message key] [message value]',
        '[eq:[message value],Message Value 2 Key Value]');

?>
