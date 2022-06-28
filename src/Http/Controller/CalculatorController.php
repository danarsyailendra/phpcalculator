<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jakmall\Recruitment\Calculator\Operation;

class CalculatorController
{
    public function calculate(Request $request, $action)
    {
        $numbers = $request->input('input');

        $operation = new Operation();
        $result = $operation->call(strtolower($action), $numbers);
        $arr_result = explode(" = ", $result);
        return new Response([
            "command" => strtolower($action),
            "operation" => $arr_result[0],
            "result" => (float)$arr_result[1]
        ], 201);
    }
}
