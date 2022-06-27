<?php

namespace Jakmall\Recruitment\Calculator\Test;

use Jakmall\Recruitment\Calculator\Operation;
use PHPUnit\Framework\TestCase;

class TestGeneralCommand extends TestCase
{
    public function testParameterNotNumeric()
    {
        $command = new Operation();
        $result = $command->call('add',[2,3,"a"]);
        $this->assertEquals("Numbers must be numeric",$result);
    }

    public function testCommandNotFound()
    {
        $command = new Operation();
        $result = $command->call('test',[2,3,4]);
        $this->assertEquals("Command not found",$result);
    }
}
