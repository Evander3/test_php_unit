<?php

define('CFG_MAX_POP', 10);
define('CFG_MIN_POP', 0);

use PHPUnit\Framework\TestCase;

require_once 'src/functions.php';

class FunctionsTest extends TestCase
{
    // public function testShowMyNameShouldContainMyName()
    // {
    //     $value = ShowMyName(randstr(5));
        
    //     $this->assertNotContains('Max',$value);
    //     $this->assertContains('max',$value);
    //     $this->assertNotContains('Mx',$value);
    // }
    
    public function testget_session_pop()
    {
        $value = 'cinq';
        get_session_pop($value);
        
        $this->assertNotNull($value);
        $this->assertinternalType('integer',$value);
        // $this->assertEquals($_SESSION['num_member'],$value);
    }
    public function testincrease()
    {
        $value = 5;
        $startvalue = $value;
        increase($value);
        
        $this->assertNotNull($value);
        $this->assertinternalType('integer',$value);
        $this->assertEquals($startvalue+1,$value);
    }
    public function testdecrease()
    {
        $value = 5;
        $startvalue = $value;
        decrease($value);
        
        $this->assertNotNull($value);
        $this->assertinternalType('integer',$value);
        $this->assertEquals($startvalue-1,$value);
    }
    // public function testresetPopCount()
    // {
    //     session_start();
    //     $value = resetPopCount();
        
    //     $this->assertNull($_COOKIE["PHPSESSID"]);
    //     // $this->assertresulternalType('integer',$value);
    //     // $this->assertEquals(9,$value);
    // }
}