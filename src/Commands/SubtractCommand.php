<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Operation;

class SubtractCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );

        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));

        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'subtract';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'subtracted';
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $operation = new Operation();
        $result = $operation->call($this->getCommandVerb(), $numbers);
        $this->comment($result);
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }
}
