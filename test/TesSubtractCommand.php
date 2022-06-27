<?php

namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TesSubtractCommand extends TestCase
{
    public function testSubtractCommandThreeParameters()
    {
        $command = new Operation();
        $result = $command->call('subtract',[9,3,4]);
        $this->assertEquals("9 - 3 - 4 = 2",$result);

    }

    public function testSubtractCommandTwoParameters()
    {
        $command = new Operation();
        $result = $command->call('subtract',[5,3]);
        $this->assertEquals("5 - 3 = 2",$result);

    }
}
