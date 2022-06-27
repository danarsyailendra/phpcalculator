<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Log\Log;

class HistoryListCommand extends Command
{
    protected $signature = "history:list {id?} {--driver=composite}";

    protected $description;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = $this->argument('id');
        $driver = $this->option('driver');

        $log = new Log($driver);
        $ret = $log->showLog($id);

        $this->table($ret["headers"],$ret["body"]);
    }
}
