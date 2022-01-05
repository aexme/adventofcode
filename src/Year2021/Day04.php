<?php

namespace Solver\Year2021;

class Day04
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
        echo "\n ### --- Day 4: Giant Squid Part1!--- ### \n";

        $numbers            = $this->getNumbers();
        $boards             = $this->getBoards();

        $result             = [];

        foreach ($numbers as $number) {
            foreach ($boards as $key => $board) {
                if([$x, $y] = $this->boardHasNumber($board, $number)){
                    $boards[$key]['rows'][$y]++;
                    $boards[$key]['collumns'][$x]++;

                    $boards[$key][$y][$x] = 'x';
                }
                
                if ([$row, $collumn] = $this->boardHasWon($boards[$key])) {
                    
                    echo "\n ### wininig number: $number ### \n ";
                    if ($row !== false) {
                        unset($board[$row]);
                    }
                    if ($collumn !== false) {
                        $board = $this->removeCollumnFromBoard($board, $collumn);
                    }

                    $sum    = $this->getSumFromBoard($board);
                    $result = $sum * $number;

                    break 2;
                }
            }
        }

        return $result;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 4: Giant Squid Part1!--- ### \n";

        $numbers            = $this->getNumbers();
        $boards             = $this->getBoards();

        foreach ($numbers as $number) {

            foreach ($boards as $key => $board) {
                if([$x, $y] = $this->boardHasNumber($board, $number)){
                    $boards[$key]['rows'][$y]++;
                    $boards[$key]['collumns'][$x]++;

                    $boards[$key][$y][$x] = 'x';
                }

                if ([$row, $collumn] = $this->boardHasWon($boards[$key])) {
                    if (count($boards)===1) {
                        $board = $boards[$key];
                        break 2;
                    }
                    unset($boards[$key]);
                }
            }
        }

        echo "\n ### last number: $number ### \n ";

        $sum                = $this->getSumFromBoard($board);
        return $sum * $number;
    }

    protected function getNumbers():array
    {
        $numbers = explode(',', $this->data[0]);
        $numbers = array_map('intval', $numbers);
        return $numbers;
    }

    protected function getBoards():array
    {
        $data               = $this->data;
        $data               =  array_splice($data, 2);

        $data[]             = '';
        $boards             = [];
        $board              = [];

        foreach ($data as $row) {
            
            if ($row === '') {
                $board['rows']      = [0,0,0,0,0];
                $board['collumns']  = [0,0,0,0,0];

                $boards[]           = $board;
                $board              = [];    
                continue;
            }

            $row            = str_replace('  ', ' ', $row);
            $board[]        = explode(' ', $row);
        }

        return $boards;
    }

    protected function boardHasNumber(array $board, int $number)
    {
        for ($i=0; $i < 5; $i++) { 
            if(!isset($board[$i])){
                return false;
            }
            $key =  array_search($number, $board[$i]);
            if($key !== false){
                return [$key, $i];
            }
        }
        return false;
    }

    protected function boardHasWon($board)
    {
        foreach ($board['rows'] as $key => $value) {
            if ($value > 4) {
                return [$key,false];
            }
        }

        foreach ($board['collumns'] as $key => $value) {
            if ($value > 4) {
                return [false, $key];
            }
        }

        return false;
    }

    protected function getSumFromBoard(array $board):int
    {
        $sum = 0;

        foreach ($board as $key => $row) {
            if (is_int($key)) {
                $sum += array_sum($row);
            }
        }

        return $sum;
    }

    protected function removeCollumnFromBoard(array $board, int $collumn)
    {
        foreach ($board as $key => $row) {
            if (is_int($key)) {
                unset($board[$key][$collumn]);
            }
        }

        return $board;
    }
}