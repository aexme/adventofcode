<?php

namespace Solver\Year2021;

use PhpParser\Node\Stmt\Foreach_;



class Day11
{

    protected array $data;

    public function __construct(array $data)
    {
        $this->data         = $data;
    }

    public function getResult($part):string
    {
        return $this->{'part' . $part}();
    }

    protected function part1():string
    {
        echo "\n ### --- Day 11: Dumbo Octopus Part1! --- ### \n";
        $sum                = 0;

        $matrix             = $this->parseData($this->data);
        for($i              = 0; $i<100; $i++){
            $matrix         = $this->increaseAll($matrix);

            [$count, $matrix] = $this->doFlashing($matrix);
            $sum            += $count;
        }

        return $sum;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 11: Dumbo Octopus Part2! --- ### \n";
        $sum                = 0;

        $matrix             = $this->parseData($this->data);
        for($i              = 0; $i<10000; $i++){
            $matrix         = $this->increaseAll($matrix);

            [$count, $matrix] = $this->doFlashing($matrix);
            $sum            += $count;

            if ($this->matrixAllZero($matrix)) {
                return $i+1;
            }
            
        }

        return $sum;
    }

    protected function matrixAllZero(array $matrix): bool
    {
        $sum     = 0;
        foreach ($matrix as $row) {
            $sum += array_sum($row);
        }

        return $sum === 0; 
    }

    protected function containsRipeOctopy(array $matrix): bool
    {
        foreach ($matrix as $row) {
            foreach ($row as $value) {
                if ($this->isRipe($value)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function doFlashing(array $matrix):array
    {
        $sum     = 0;

        while ($this->containsRipeOctopy($matrix)) {
            foreach ($matrix as $i  => $row) {
                foreach ($row as $j => $value) {
                    [$count, $matrix]   = $this->doFlash([$i, $j], $matrix);
                    $sum               += $count;
                }
            }   
        }

        $matrix = $this->resetFlashCount($matrix);

        return [$sum, $matrix];
    }

    protected function resetFlashCount(array $matrix): array
    {
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                if ($value === 'f') {
                    $matrix[$i][$j] = 0;
                }
            }
        }

        return $matrix;
    }

    protected function doFlash(array $point, array $matrix): array
    {
        [$i, $j]            = $point;

        if (!$this->shouldFlash([$i, $j], $matrix)) {
            return [0, $matrix];
        }

        $matrix[$i][$j]     = 'f';

        //up
        $matrix             = $this->increaseOne([$i-1, $j], $matrix);
        //down
        $matrix             = $this->increaseOne([$i+1, $j], $matrix);
        //left
        $matrix             = $this->increaseOne([$i, $j-1], $matrix);
        //right
        $matrix             = $this->increaseOne([$i, $j+1], $matrix);
        // dupl
        $matrix             = $this->increaseOne([$i-1, $j-1], $matrix);
        // dupr
        $matrix             = $this->increaseOne([$i-1, $j+1], $matrix);
        // ddownr
        $matrix             = $this->increaseOne([$i+1, $j+1], $matrix);
        // ddownl
        $matrix             = $this->increaseOne([$i+1, $j-1], $matrix);

        return [1, $matrix];
    }

    protected function shouldFlash(array $point, array $matrix): bool
    {
        return !$this->isOut($point, $matrix) && $this->isRipe($matrix[$point[0]][$point[1]]);
    }

    protected function isRipe($value):bool
    {
        return $value > 9 && $value !== 'f';
    }

    protected function isOut(array $point, array $matrix): bool
    {
        return !isset($matrix[$point[0]][$point[1]]);
    }

    protected function parseData(array $data): array
    {
        $matrix         = [];
        foreach ($data as $row) {
            $matrix[]   = str_split($row);
        }
        return $matrix;
    }

    protected function increaseAll(array $matrix): array
    {
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                $matrix = $this->increaseOne([$i, $j], $matrix);
            }
        }

        return $matrix;
    }

    protected function increaseOne(array $point, array $matrix): array
    {
        [$i, $j] = $point;

        if (!$this->isOut($point, $matrix) && $matrix[$i][$j] !== 'f') {
            $matrix[$i][$j] += 1;
        }
        return $matrix;
    }
}