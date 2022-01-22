<?php

namespace Solver\Year2021;

class Day13
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
        echo "\n ### --- Day 12: Passage Pathing Part1! --- ### \n";
        
        [$points, $instructions]    = $this->parseData($this->data);
        
        $map                        = $this->buildMap($points);        
        $map                        = $this->fold($map, $instructions[0]);

        return $this->countPoints($map);
    }

    protected function part2():string
    {
        echo "\n ### --- Day 12: Passage Pathing Part2! --- ### \n";
        [$points, $instructions]    = $this->parseData($this->data);
        
        $map                        = $this->buildMap($points);
        foreach ($instructions as $instruction) {
            $map                    = $this->fold($map, $instruction);
        }
        
        $output = "\n";
        foreach ($map as $row) {
            foreach ($row as $key => $value) {
                $row[$key] = $value?'#': ' ';
            }
            $output .= implode('', $row) . "\n";
        }

        return $output;
    }
    
    protected function parseData(array $data): array
    {
        $points         = [];
        $instructions   = [];

        foreach ($data as $row) {
            if(!$row  ){
                continue;
            }

            if(strpos($row, ',') !== false){
                $points[]       = explode(',', $row);
            }

            if(strpos($row, 'fold') !== false){
                $row            = str_replace('fold along ', '', $row);
                $instructions[] = explode('=', $row);
            }
        }

        return [$points, $instructions];
    }

    protected function getMapDimensions(array $points): array
    {
        $max_row                = 0;
        $max_col                = 0;

        foreach ($points as [$collumn, $row]) {
            
            if ($row > $max_row) {
                $max_row    = $row;
            }
            if ($collumn > $max_col) {
                $max_col    = $collumn;
            }            
        }

        return [$max_row, $max_col];
    }

    protected function buildMap(array $points): array
    {
        [$rows, $cols]          = $this->getMapDimensions($points);

        $map                    = array_fill(0, $rows+1, array_fill(0, $cols+1, 0));
        $map                    = $this->fillMap($map, $points);

        return $map;
    }

    protected function fillMap(array $map, array $points): array
    {
        foreach ($points as [$y, $x]) {
            $map[$x][$y] = 1;
        }

        return $map;
    }

    protected function fold(array $map, array $instruction): array
    {
        [$direction, $position] = $instruction;

        
        if ($direction === 'y') {
            $map_len            = count($map);

            $target_row = $position-1;
            for ($i = $position+1; $i < $map_len; $i++) { 
                if(!isset($map[$i]) || !isset($map[$target_row])){
                    break;
                }
                
                foreach ($map[$i] as $key => $value) {
                    $map[$target_row][$key] = $map[$target_row][$key] || $value;
                }
                $target_row--;
                unset($map[$i]);
            }
            unset($map[$position]);
        }
        
        if ($direction === 'x') {
            $map_len            = count($map[0]);
            
            
            foreach ($map as $key => $row) {
                $target_col = $position-1;
                for ($i=$position+1; $i < $map_len; $i++) { 
                    if(!isset($map[$key][$i]) || !isset($map[$key][$target_col])){
                        break;
                    }

                    $map[$key][$target_col] = $map[$key][$target_col] || $row[$i];

                    $target_col--;
                    unset($map[$key][$i]);
                }

                unset($map[$key][$position]);
            }
            
        }

        return $map;
        
    }

    protected function countPoints(array $map): int
    {
        $sum = 0;
        foreach ($map as $row) {
            $sum += array_sum($row);
        }
        return $sum;
    }
}