<?php

namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TestMultiplyCommand extends TestCase
{
    public function testMultiplyCommandThreeParameters()
    {
        $command = new Operation();
        $result = $command->call('multiply',[2,3,4]);
        $this->assertEquals("2 * 3 * 4 = 24",$result);

    }

    public function testMultiplyCommandTwoParameters()
    {
        $command = new Operation();
        $result = $command->call('multiply',[4,2]);
        $this->assertEquals("4 * 2 = 8",$result);

    }
}
