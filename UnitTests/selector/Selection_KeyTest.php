<?php

include_once dirname(__FILE__) . '/../../selector/Selection_Key.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-12-29 at 13:28:52.
 */
class Selection_KeyTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Selection_Key
     */
    protected $object;
    
    protected $simpleKeys = array('a', '0', '0b', 2, 'a_', 'a ', 'abc', '1.2', 1, 0);
    
    protected $simpleInput = array('a'=>2, 'b'=>[1,2,3,4], 'c'=>null, 'd'=>'abc', 'e'=>1.2, 'f'=>'1.2', 'g'=>true, 'h'=>0, 'i'=>1, 'j'=>[], '0'=>'a', '0b'=>'b', 2=>'c', 'a_'=>'d', 'a '=>'e', 'abc'=>'f', '1.2'=>'g', 1=>'h', 0=>'i');



    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Selection_Key;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }    
    
    private function simpleListTest($test, $callback){
        for($i=0;$i<count($test);$i++){
            $expected = $test[$i][0];
            $param = $test[$i][1];
            
            $res = $this->object->$callback($this->simpleKeys, $this->simpleInput, null, $param);
            self::assertSame(array('keys'=>$expected), $res);
        }
    }

    /**
     * @covers Selection_Key::getIndicator
     */
    public function testGetIndicator() {
        self::assertEquals('key', $this->object->getIndicator());
    }

    /**
     * @covers Selection_Key::select_key
     */
    public function testSelect_key() {
        $this->simpleListTest([[['a'], 'a'],
                               [['0'], '0'],
                               [['a_'], 'a_'],
                               [['abc'], 'abc'],
                               [[2], 2],
                               [[''], '']],
                'select_key');
    }

    /**
     * @covers Selection_Key::select_key_list
     */
    public function testSelect_key_list() {
        $this->simpleListTest([[['a'], ['a']],
                               [['0'], ['0']],
                               [['a_'], ['a_']],
                               [['abc'], ['abc']],
                               [['a','abc'], ['a','abc']],
                               [['a','abc2'], ['a','abc2']],
                               [['',''], ['','']],
                               [['a','a'], ['a','a']]],
                'select_key_list');
    }

    /**
     * @covers Selection_Key::select_key_all
     */
    public function testSelect_key_all() {
        $this->simpleListTest([[$this->simpleKeys, null]],
                'select_key_all');
    }

    /**
     * @covers Selection_Key::select_key_regex
     */
    public function testSelect_key_regex() {
        $this->simpleListTest([[['a'], '%^a$%'],
                               [['0', '0b', 0], '%^0%'],
                               [[], '%^abbbbbbb$%']],
                'select_key_regex');
    }

    /**
     * @covers Selection_Key::select_key_numeric
     * @todo   Implement testSelect_key_numeric().
     */
    public function testSelect_key_numeric() {
        $this->simpleListTest([[['0', 2, 1, 0], null]],
                'select_key_numeric');
    }

    /**
     * @covers Selection_Key::select_key_integer
     */
    public function testSelect_key_integer() {
        $this->simpleListTest([[[2, 1, 0], null]],
                'select_key_integer');
    }

    /**
     * @covers Selection_Key::select_key_min_numeric
     */
    public function testSelect_key_min_numeric() {
        $this->simpleListTest([[['0', 2, 1, 0], 0],
                               [[2, 1], 1],
                               [[], 9]],
                'select_key_min_numeric');
    }

    /**
     * @covers Selection_Key::select_key_max_numeric
     */
    public function testSelect_key_max_numeric() {
        $this->simpleListTest([[['0', 2, 1, 0], 2],
                               [['0', 1, 0], 1],
                               [[], -1]],
                'select_key_max_numeric');
    }

    /**
     * @covers Selection_Key::select_key_starts_with
     */
    public function testSelect_key_starts_with() {
        $this->simpleListTest([[['a', 'a_', 'a ', 'abc'], 'a'],
                               [['0', '0b', 0], '0'],
                               [['a_'], 'a_'],
                               [['abc'], 'abc'],
                               [[], 'abc2']],
                'select_key_starts_with');
    }

    /**
     * @covers Selection_Key::select_key_union
     */
    public function testSelect_key_union() {
        $this->simpleListTest([[['tt'], ['key'=>'tt']],
                               [$this->simpleKeys, ['key_all']],
                               [array_merge($this->simpleKeys, ['tt']), ['key_all', 'key'=>'tt']]],
                'select_key_union');
    }

    /**
     * @covers Selection_Key::select_key_intersection
     */
    public function testSelect_key_intersection() {
        $this->simpleListTest([[['tt'], ['key'=>'tt']],
                               [$this->simpleKeys, ['key_all']],
                               [[], ['key_all', 'key'=>'tt']],
                               [['abc'], ['key_all', 'key'=>'abc']]],
                'select_key_intersection');
    }

}
