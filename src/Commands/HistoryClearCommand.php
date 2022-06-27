<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Log\Log;

class HistoryClearCommand extends Command
{
    protected $signature = "history:clear {id?} {--driver=composite}";

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
        $ret = $log->deleteLog($id);

        $this->comment($ret);
    }
}
