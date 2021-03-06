<?php
namespace Solver\Year2021;

class Day01
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
        echo "\n ### --- Day 1: Sonar Sweep Part1!--- ### \n";

        $increases  = 0;
        $prevval    = -1;
        foreach ($this->data as $value) {
            if($prevval>0){
                if ($value >= $prevval){
                    $increases++;
                }
            }

            $prevval = $value;
        }
        
        return (string)$increases;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 1: Sonar Sweep Part1!--- ### \n";

        $increases  = 0;
        $prevsum    = -1;
    
        foreach ($this->data as $key => $value) {
            
            $sum    = $this->getSum($key, $this->data);
            if (!$sum) {
                break;
            }

            if($prevsum>0 && $sum > $prevsum){
                $increases++;
            }

            $prevsum = $sum;
        }
        return (string)$increases;
    }

    protected function getSum(int $index, array $data):int
    {
        if (!isset($data[$index+2])) {
            return false;
        }

        return $data[$index] + $data[$index + 1] + $data[$index + 2];
    }
}