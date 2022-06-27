<?php

namespace Jakmall\Recruitment\Calculator\Log;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    protected $config;

    protected $driver;

    protected $monolog;

    protected $dateFormat = "Y n j, h:i:s";

    protected $output = "[%datetime%]|%message%\n";

    public function __construct($driver = 'composite')
    {
        $this->config = [
            "file" => [
                "path" => "logs/mesinhitung.log"
            ],
            "latest" => [
                "path" => "logs/latest.log"
            ],
            "composite" => [
                "driver" => ["file", "latest"]
            ]
        ];

        $this->monolog = new Logger($driver);
        $this->driver = $driver;
    }

    public function insertLog($message, $from_composite = false)
    {

        $path = $this->resolvePath();
        if ($this->driver != 'composite') {
            $id = (!$from_composite) ? $this->getNewId() : $this->getNewId() - 1;
            if ($this->driver == 'file') {
                $this->addLog($path[0], $id, $message);
            } else {
                $this->insertLatest($path[0], $id, $message);
            }
        } else {
            $file = new Log("file");
            $file->insertLog($message);

            $latest = new Log("latest");
            $latest->insertLog($message, true);
        }

    }

    protected function insertLatest($path, $id, $message)
    {
        $count_line = 0;
        $file = [];
        if (file_exists($path)) {
            $file = file($path);
            $count_line = count($file);
        }

        if ($count_line >= 10) {
            unset($file[0]);
            file_put_contents($path, implode("", $file));
        }

        $this->addLog($path, $id, $message);
    }

    protected function addLog($path, $id, $message)
    {
        $formatter = new LineFormatter($this->output, $this->dateFormat);
        $stream = new StreamHandler($path, Logger::INFO);
        $stream->setFormatter($formatter);
        $this->monolog->pushHandler($stream);
        $this->monolog->info(sprintf('%s|%s', $id, $message));
        $this->monolog->close();
    }

    protected function resolvePath(): array
    {
        if ($this->driver != 'composite') {
            return [$this->config[$this->driver]['path']];
        } else {
            return [
                $this->config[$this->config[$this->driver]['driver'][0]]['path'],
                $this->config[$this->config[$this->driver]['driver'][1]]['path'],
            ];
        }
    }

    protected function getNewId(): int
    {
        $path_file = $this->config["file"]['path'];
        $path_latest = $this->config["latest"]['path'];

        if (file_exists($path_file) && file_exists($path_latest)) {

            $arr_file = file($path_file);
            $arr_latest = file($path_latest);
            $latest_id_file = explode("|", $arr_file[count($arr_file) - 1])[1];
            $latest_id_latest = explode("|", $arr_latest[count($arr_latest) - 1])[1];
            $latest_id = max($latest_id_file, $latest_id_latest);

            return intval($latest_id) + 1;
        } elseif (file_exists($path_file) || file_exists($path_latest)) {
            $path = (file_exists($path_file)) ? $path_file : $path_latest;
            $file = file($path);
            $last_record = $file[count($file) - 1];
            $exp = explode("|", $last_record);

            return intval($exp[1]) + 1;
        } else {
            return 1;
        }
    }

    public function deleteLog($id = null)
    {
        if ($id != null) {
            if ($this->driver != 'composite') {
                $path = $this->config[$this->driver]['path'];
                $this->removeLog($path, $id);
            } else {
                $paths = $this->resolvePath();
                foreach ($paths as $path) {
                    $this->removeLog($path, $id);
                }
            }
            return sprintf('Data with ID %s is removed',$id);
        }else{
            if ($this->driver != 'composite') {
                $path = $this->config[$this->driver]['path'];
                $this->clearLog($path);
            }else{
                $paths = $this->resolvePath();
                foreach ($paths as $path) {
                    $this->clearLog($path);
                }
            }
            return "All history is cleared";
        }
    }

    protected function findIndex($array, $id)
    {
        foreach ($array as $index => $item) {
            $item_id = explode("|", $item)[1];
            if ($id == $item_id) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @param $id
     * @return void
     */
    protected function removeLog($path, $id): void
    {
        if (file_exists($path)) {
            $file = file($path);
            $index = $this->findIndex($file, $id);
            if ($index != null) {
                unset($file[$index]);
                file_put_contents($path, implode("", $file));
            }

        }
    }

    protected function clearLog($path){
        if (file_exists($path)) {
            file_put_contents($path, "");
        }
    }
}
