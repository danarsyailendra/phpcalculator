<?php

namespace Jakmall\Recruitment\Calculator;

class Operation
{
    public function call(string $command = null, array $param = []): string
    {
        if ($command == 'add') {
            return $this->add($param);
        }else if ($command == 'subtract'){
            return $this->subtract($param);
        }else if($command == 'divide'){
            return $this->divide($param);
        }else if($command == 'multiply'){
            return $this->multiply($param);
        }else if($command == 'power'){
            return $this->power($param);
        }else{
            return "Command not found";
        }
    }

    private function add(array $numbers): string
    {
        $operator = "+";

        return $this->getDescription($operator, $numbers);

    }

    private function subtract(array $numbers):string
    {
        $operator = "-";

        return $this->getDescription($operator, $numbers);
    }

    private function divide(array $numbers): string
    {
        $operator = "/";

        return $this->getDescription($operator, $numbers);

    }

    private function multiply(array $numbers): string
    {
        $operator = "*";

        return $this->getDescription($operator, $numbers);

    }

    private function power(array $numbers): string
    {
        $operator = "^";

        return $this->getDescription($operator, $numbers);

    }

    private function getDescription(string $operator, array $numbers): string
    {
        $glue = sprintf(' %s ', $operator);

        $description = implode($glue, $numbers);
        $result = $this->calculateAll($operator, $numbers);
        if ($result === false) {
            return "Numbers must be numeric";
        } else {
            return sprintf('%s = %s', $description, $result);
        }
    }


    /**
     * @param string $command
     * @param array $numbers
     * @return false|float|int|string|void
     */
    private function calculateAll(string $command, array $numbers)
    {
        $number = array_pop($numbers);
        if (is_numeric($number)) {
            if (count($numbers) <= 0) {
                return $number;
            }

            if ($command == '+') {
                return $this->calculateAdd($this->calculateAll($command, $numbers), $number);
            }elseif ($command == '-') {
                return $this->calculateSubtract($this->calculateAll($command, $numbers), $number);
            }elseif ($command == '/') {
                return $this->calculateDivide($this->calculateAll($command, $numbers), $number);
            }elseif ($command == '*') {
                return $this->calculateMultiply($this->calculateAll($command, $numbers), $number);
            }else {
                return $this->calculatePower($this->calculateAll($command, $numbers), $number);
            }

        } else {
            return false;
        }
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    private function calculateAdd(float $number1, float $number2)
    {
        return $number1 + $number2;
    }

    /**
     * @param float $number1
     * @param float $number2
     *
     * @return int|float
     */
    private function calculateSubtract(float $number1, float $number2)
    {
        return $number1 - $number2;
    }

    /**
     * @param float $number1
     * @param float $number2
     *
     * @return int|float
     */
    private function calculateDivide(float $number1, float $number2)
    {
        return $number1 / $number2;
    }

    /**
     * @param float $number1
     * @param float $number2
     *
     * @return int|float
     */
    private function calculateMultiply(float $number1, float $number2)
    {
        return $number1 * $number2;
    }

    /**
     * @param float $number1
     * @param float $number2
     *
     * @return int|float
     */
    private function calculatePower(float $number1, float $number2)
    {
        return pow($number1,$number2);
    }
}
