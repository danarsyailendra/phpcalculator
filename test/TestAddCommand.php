<?php
namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TestAddCommand extends TestCase
{

    public function testAddCommandThreeParameters()
    {
        $command = new Operation();
        $result = $command->call('add',[2,3,4]);
        $this->assertEquals("2 + 3 + 4 = 9",$result);

    }

    public function testAddCommandTwoParameters()
    {
        $command = new Operation();
        $result = $command->call('add',[2,3]);
        $this->assertEquals("2 + 3 = 5",$result);

    }
}
