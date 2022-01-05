<?php

namespace Solver\Year2021;

class Day03
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
        echo "\n ### --- Day 3: Binary Diagnostic Part1!--- ### \n";

        $gamma          = '';        
        $row_length     = strlen($this->data[0]);
        $row_count      = count($this->data);

        for ($i=0; $i < $row_length; $i++) { 
                      
            $ones       = $this->countOnesInCollumn($this->data, $i);
            $value      = '0';

            // if more ones than zeroes in collumn add "1" else add "0"
            if ($ones > ($row_count-$ones)) {
                $value  = '1';
            }

            $gamma     .= $value;
        }

        // create inverted binary 101 -> 010
        $epsilon        = strtr($gamma,['1','0']);

        return (string)(bindec($gamma) * bindec($epsilon));
    }

    protected function part2():string
    {
        echo "\n ### --- Day 3: Binary Diagnostic Part2!--- ### \n";
        
        return (string)($this->oxygenRating() * $this->getCo2Rating());
    }

    protected function oxygenRating():int
    {
        $row_length     = strlen($this->data[0]);
        $rows           = $this->data;

        for ($i=0; $i < $row_length; $i++) { 
            $value      = $this->getMostCommonValue($rows, $i);
            $rows       = $this->getRowsWithValue($rows, $value, $i);

            if (count($rows) === 1) {
                break;
            }
        }

        return (string)(bindec($rows[0]));
    }

    protected function getCo2Rating():int
    {
        $row_length     = strlen($this->data[0]);
        $rows           = $this->data;

        for ($i=0; $i < $row_length; $i++) { 
            $value      = $this->getLeastCommonValue($rows, $i);
            $rows       = $this->getRowsWithValue($rows, $value, $i);

            if (count($rows) === 1) {
                break;
            }
        }

        return (string)(bindec($rows[0]));
    }

    protected function getRowsWithValue(array $data, int $value, int $collumn):array
    {
        $rows           = [];
        foreach ($data as $row) {
            if ($row[$collumn] === (string)$value) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    protected function countOnesInCollumn(array $data, int $collumn):int
    {
        $ones           = 0;
        foreach ($data as $row) {
            $ones      += $row[$collumn];
        }

        return $ones;
    }

    protected function getMostCommonValue(array $data, int $collumn):int
    {        
        $row_count      = count($data);
        $ones           = $this->countOnesInCollumn($data, $collumn);

        if ($ones >= ($row_count-$ones)) {
            return 1;
        }

        return 0;
    }

    protected function getLeastCommonValue(array $data, int $collumn):int
    {   
        $row_count      = count($data);     
        $ones           = $this->countOnesInCollumn($data, $collumn);

        if ($ones >= ($row_count-$ones)) {
            return 0;
        }

        return 1;
    }
}