<?php

namespace Solver\Year2021;

class Day07
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
        echo "\n ### --- Day 7: The Treachery of Whales Part1!--- ### \n";

        $positions          = explode(',', $this->data[0]);
        $sums               = [];

        [$max_pos, $min_pos] = $this->getLimitPositions($positions);

        for ($i = $min_pos; $i <= $max_pos; $i++) { 

            foreach ($positions as $pos) {

                if (!isset($sums[$i])) {
                    $sums[$i] = 0;
                }

                $sums[$i]  += abs($pos - $i);
            }
        }
        
        $total_fuel         = min($sums);

        return $total_fuel;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 7: The Treachery of Whales Part2! --- ### \n"; 

        $positions          = explode(',', $this->data[0]);
        $sums               = [];

        [$max_pos, $min_pos] = $this->getLimitPositions($positions);

        for ($i = $min_pos; $i <= $max_pos; $i++) { 

            foreach ($positions as $pos) {

                if (!isset($sums[$i])) {
                    $sums[$i] = 0;
                }

                $diff       = abs($pos - $i);
                $fuel       = 0;
                for ($j = 0; $j <= $diff; $j++) { 
                    $fuel  += $j;
                }
                $sums[$i]  += $fuel;
            }
        }
        
        $total_fuel         = min($sums);

        return $total_fuel;
    }

    protected function getLimitPositions(array $positions):array
    {
        $max_pos    = max($positions);
        $min_pos    = min($positions);

        return [$max_pos, $min_pos];
    }
}