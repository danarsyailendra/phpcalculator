<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jakmall\Recruitment\Calculator\Log\Log;

class HistoryController
{
    public function index(Request $request): array
    {
        $driver = $request->query('driver') ?? "composite";
        $log = new Log($driver);
        $logs = $log->showLog();
        $return = [];

        foreach ($logs['body'] as $item) {
            $ret = [
                strtolower($logs["headers"][0]) => $item[0],
                strtolower($logs["headers"][1]) => $item[1],
                strtolower($logs["headers"][2]) => $item[2],
                "input" => $this->splitOperation($item[1], $item[2]),
                strtolower($logs["headers"][3]) => (int)str_replace("\n", "", $item[3]),
            ];

            $return[] = $ret;
        }

        return $return;
    }

    public function show(Request $request, $id)
    {
        $driver = $request->query('driver') ?? "composite";
        $log = new Log($driver);
        $logs = $log->showLog($id);
        if (empty($logs["body"])){
            return [];
        }
        return [
            strtolower($logs["headers"][0]) => $logs["body"][0][0],
            strtolower($logs["headers"][1]) => $logs["body"][0][1],
            strtolower($logs["headers"][2]) => $logs["body"][0][2],
            "input" => $this->splitOperation($logs["body"][0][1], $logs["body"][0][2]),
            strtolower($logs["headers"][3]) => (int)str_replace("\n", "", $logs["body"][0][3]),
        ];
    }

    public function remove($id)
    {
        $log = new Log();
        $log->deleteLog($id);
        return new Response("",204);
    }

    private function splitOperation($operation, $input): array
    {
        if ($operation == "Add") {
            return array_map('intval', explode(" + ", $input));
        } elseif ($operation == "Subtract") {
            return array_map('intval', explode(" - ", $input));
        } elseif ($operation == "Divide") {
            return array_map('intval', explode(" / ", $input));
        } elseif ($operation == "Multiply") {
            return array_map('intval', explode(" * ", $input));
        } else {
            return array_map('intval', explode(" ^ ", $input));
        }
    }
}
