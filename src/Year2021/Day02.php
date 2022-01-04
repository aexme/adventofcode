<?php

namespace Solver\Year2021;

class Day02
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
        $h_pos          = 0;
        $depth          = 0;

        foreach ($this->data as $command) {
            [$direction, $value] = explode(' ', $command);
            if ($direction === 'forward') {
                $h_pos += (int)$value;
            }

            if ($direction === 'up') {
                $depth -= (int)$value;
            }

            if ($direction === 'down') {
                $depth += (int)$value;
            }
        }

        return (string)($depth*$h_pos);
    }

    protected function part2():string
    {
        $h_pos          = 0;
        $depth          = 0;
        $aim            = 0;

        foreach ($this->data as $command) {
            [$direction, $value] = explode(' ', $command);
            if ($direction === 'forward') {
                $h_pos += (int)$value;
                $depth += $value * $aim;
            }

            if ($direction === 'up') {
                $aim  -= (int)$value;
            }

            if ($direction === 'down') {
                $aim   += (int)$value;
            }
        }

        return (string)($depth*$h_pos);
    }
}