<?php

namespace Solver\Year2021;

class Day04
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getResult($part):string
    {
        return $this->{'part' . $part}();
    }

    protected function part1():string
    {
        $numbers = $this->getNumbers();
        return (string)11;
    }

    protected function part2():string
    {
        return (string)12;
    }

    protected function getNumbers()
    {
        $numbers = explode(',', $this->data[0]);
        $numbers
    }
}