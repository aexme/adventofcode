<?php

namespace Solver\Year2021;

class Day06
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
        echo "\n ### --- Day 6: Lanternfish Part1!--- ### \n";
        return array_sum($this->simulateFish(80));
    }

    protected function part2():string
    {
        echo "\n ### --- Day 6: Lanternfish Venture Part2! --- ### \n";        
        return array_sum($this->simulateFish(256));
    }

    protected function simulateFish($days_to_run)
    {
        $fishes     = explode(',', $this->data[0]);
        $fishes     = array_map('intval', $fishes);

        $fish_states    = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
        ];

        foreach ($fishes as $fish) {
            $fish_states[$fish]++;
        }

        for ($day = 0; $day < $days_to_run; $day++) { 
            $new_counts                 = [];
            for ($i = 8; $i >= 0; $i--) { 
                if($i > 0 ){
                    $new_counts[$i-1]   = $fish_states[$i];
                }else{
                    // add new fish at state8 and move fish form state 0 to state 6
                    $new_counts[8]      = $fish_states[$i];
                    $new_counts[6]     += $fish_states[$i];
                }

            }
            $fish_states                = $new_counts;
        }

        return $fish_states;
    }
}