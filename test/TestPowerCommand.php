<?php

namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TestPowerCommand extends TestCase
{
    public function testPowerCommandThreeParameters()
    {
        $command = new Operation();
        $result = $command->call('power',[8,2,2]);
        $this->assertEquals("8 ^ 2 ^ 2 = 4096",$result);

    }

    public function testPowerCommandTwoParameters()
    {
        $command = new Operation();
        $result = $command->call('power',[3,3]);
        $this->assertEquals("3 ^ 3 = 27",$result);

    }
}
