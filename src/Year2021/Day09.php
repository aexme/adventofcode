<?php

namespace Solver\Year2021;

use PhpParser\Node\Stmt\Foreach_;

class Day09
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
        echo "\n ### --- Day 9: Smoke Basin Part1! --- ### \n";

        $matrix     = $this->buildMatrix($this->data);
        $low_points = $this->getLowpoints($matrix);

        $sum        = 0;

        foreach ($low_points as $point) {
            $sum   += $matrix[$point[0]][$point[1]] + 1;
        }

        return $sum;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 9: Smoke Basin Part2! --- ### \n"; 

        $matrix         = $this->buildMatrix($this->data);
        $low_points     = $this->getLowpoints($matrix);
        foreach ($low_points as $point) {
            $basin      = $this->getBasin($point, $matrix);
            $basins[]   = $this->getBasinSize($basin);
        }
        
        asort($basins);
        $largest3       = array_slice($basins, count($basins)-3, 3);

        $result         = 1;
        foreach ($largest3 as $value) {
            $result    *= $value;
        }

        return (string)$result;
    }

    protected function buildMatrix(array $data)
    {
        $matrix = [];
        foreach ($data as $row) {
            $matrix[] = str_split($row);
        }

        return $matrix;
    }

    protected function getLowpoints($matrix)
    {
        $low_points                     = []; 
        foreach ($matrix as $i  => $row) {
            foreach ($row as $j => $number) {

                $surounding_values      = [];

                // above
                if (isset($matrix[$i-1][$j])) {
                    $surounding_values[] = $matrix[$i-1][$j];
                }

                // left
                if (isset($matrix[$i][$j-1])) {
                    $surounding_values[] = $matrix[$i][$j-1];
                }

                // right
                if (isset($matrix[$i][$j+1])) {
                    $surounding_values[] = $matrix[$i][$j+1];
                }

                // belov
                if (isset($matrix[$i+1][$j])) {
                    $surounding_values[] = $matrix[$i+1][$j];
                }

                $min                    = min($surounding_values);
                if ($number<$min) {
                    $low_points[]       = [$i, $j];
                }
            }
        }

        return $low_points;
    }

    protected function getBasin(array $point, array $matrix): array
    {
        $rows   = count($matrix);
        $cols   = count($matrix[0]);
        
        $basin  = array_fill(0, $rows+1, array_fill(0, $cols+1, 0));

        $matrix = $this->explore($point, $matrix);

        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                if ($value === 'x') {
                    $basin[$i][$j] = 1;
                }
            }
        }

        return $basin;
    }

    protected function getBasinSize(array $basin)
    {
        $sum        = 0;
        foreach ($basin as $row) {
            $sum   += array_sum($row);
        }
        return $sum;
    }

    protected function explore(array $point, array $matrix):array
    { 
        if (!$this->pointOfInterest($point, $matrix)) {
            return $matrix;
        }

        $row                = $point[0];
        $col                = $point[1];

        $matrix[$row][$col] = 'x';
        
        $matrix             = $this->explore([$row-1, $col], $matrix);
        $matrix             = $this->explore([$row+1, $col], $matrix);
        $matrix             = $this->explore([$row,   $col-1], $matrix);
        $matrix             = $this->explore([$row,   $col+1], $matrix);
        
        return $matrix;
    }

    protected function pointOfInterest($point, $matrix):bool
    {
        $value              = $matrix[$point[0]][$point[1]]??false;
        if ($value !== false && $value < 9 && $value !== 'x') {
            return true;
        }
        return false;
    }
}