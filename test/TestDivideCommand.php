<?php

namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TestDivideCommand extends TestCase
{
    public function testDivideCommandThreeParameters()
    {
        $command = new Operation();
        $result = $command->call('divide',[16,4,2]);
        $this->assertEquals("16 / 4 / 2 = 2",$result);

    }

    public function testDivideCommandTwoParameters()
    {
        $command = new Operation();
        $result = $command->call('divide',[4,2]);
        $this->assertEquals("4 / 2 = 2",$result);

    }
}
