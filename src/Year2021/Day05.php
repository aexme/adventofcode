<?php

namespace Solver\Year2021;

class Day05
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
        echo "\n ### --- Day 5: Hydrothermal Venture Part1!--- ### \n";
        $map    = $this->buildMap();
        return $this->countOverlappingLines($map);
    }

    protected function part2():string
    {
        echo "\n ### --- Day 5: Hydrothermal Venture Part2! --- ### \n";
        $map    = $this->buildMap(true);
        return $this->countOverlappingLines($map);
    }

    protected function getMapDimensions():array
    {
        $max                = 0;

        foreach ($this->data as $row) {
            $coordinates    = $this->parseInputRow($row);
            foreach ($coordinates as [$row, $collumn]) {
                if ($row > $max) {
                    $max    = $row;
                }
                if ($collumn > $max) {
                    $max    = $collumn;
                }
            }            
        }

        return [$max, $max];
    }

    protected function parseInputRow(string $row):array
    {
        [$start, $end]      = explode('->', $row);
        $start_coordinates  = array_map('intval', explode(',', $start));
        $end_coordinates    = array_map('intval', explode(',', $end));

        return [$start_coordinates, $end_coordinates];
    }

    protected function buildMap($advanced=false):array
    {
        [$rows, $collumns]    = $this->getMapDimensions();

        $map        = array_fill(0, $rows+1, array_fill(0, $collumns+1, 0));
        $map        = $this->fillMap($map, $advanced);

        return $map;
    }

    protected function fillMap($map, $advanced = true):array
    {
        foreach ($this->data as $row) {
            [$start, $end]  = $this->parseInputRow($row);

            if ($start[0] === $end[0]) {
                $map        = $this->fillCollumn($map, $start, $end);
            }elseif($start[1] === $end[1]) {
                $map        = $this->fillRow($map, $start, $end);
            }elseif($advanced) {
                $map        = $this->fillDiagonal($map, $start, $end);
            }
        }

        return $map;
    }

    protected function fillCollumn(array $map, array $start, array $end):array
    {
        $from       = $start[1];
        $till       = $end[1];

        if ($from > $till) {
            $till   = $start[1];
            $from   = $end[1];
        }

        for ($i = $from; $i <= $till; $i++) { 
            $map[$i][$start[0]]++;
        }

        return $map;
    }

    protected function fillRow(array $map, array $start, array $end):array
    {
        $from       = $start[0];
        $till       = $end[0];

        if ($from > $till) {
            $till   = $start[0];
            $from   = $end[0];
        }

        for ($i = $from; $i <= $till; $i++) { 
            $map[$start[1]][$i]++;
        }

        return $map;
    }

    protected function fillDiagonal(array $map, array $start, array $end):array
    {
        $row_from       = $start[0];
        $row_till       = $end[0];

        $col_from       = $start[1];
        $col_till       = $end[1];
        $col_step       = 1;

        if ($row_from > $row_till) {
            $row_from   = $end[0];
            $row_till   = $start[0];
            $col_from   = $end[1];
            $col_till   = $start[1];
        }

        if ($col_from > $col_till) {
            $col_step   = -1;
        }

        for ($i=$row_from; $i <= $row_till; $i++) { 
            $map[$col_from][$i]++;
            $col_from = $col_from + $col_step;
        }
        
        return $map;
    }

    protected function countOverlappingLines(array $map)
    {
        $count = 0;
        foreach ($map as $key => $row) {
            foreach ($row as $value) {
                if ($value >1) {
                    $count++;
                }
            }
        }

        return $count;
    }
}