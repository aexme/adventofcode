<?php

namespace Solver\Year2021;

class Day08
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
        echo "\n ### --- Day 8: Seven Segment Search Part1! --- ### \n";

        return '09';
    }

    protected function part2():string
    {
        echo "\n ### --- Day 8: Seven Segment Search Part2! --- ### \n"; 


        return '10';
    }

}