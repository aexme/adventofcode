<?php

namespace Solver\Year2021;

use PhpParser\Node\Stmt\Foreach_;

class Day08
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
        echo "\n ### --- Day 8: Seven Segment Search Part1! --- ### \n";

        $count = 0;

        foreach ($this->data as $key => $row) {
            [$input, $output] = $this->parseRow($row);
            foreach ($output as $value) {
                
                if (strlen($value) === 2) {
                    $count++;
                }

                if (strlen($value) === 3) {
                    $count++;
                }

                if (strlen($value) === 4) {
                    $count++;
                }

                if (strlen($value) === 7) {
                    $count++;
                }
            }
        }

        return $count;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 8: Seven Segment Search Part2! --- ### \n"; 

        $sum = 0;
        foreach ($this->data as $key => $row) {
            [$input, $output] = $this->parseRow($row);
            
            $map = $this->generateMap($input);
            $number = '';
            foreach ($output as $value) {
                $number .= $this->decode($value, $map);
            }

            $sum += $number;
        }

        return $sum;

    }

    protected function parseRow($row)
    {
        [$input, $output] = array_map('trim', explode('|', $row));

        return [explode(' ', $input), explode(' ', $output)];
    }

    protected function generateMap(array $input)
    {
        $map = [
            0 => false,
            1 => false,
            2 => false,
            3 => false,
            4 => false,
            5 => false,
            6 => false,
        ];

        $segments_1 = $this->getInputByLen($input, 2);
        $segments_7 = $this->getInputByLen($input, 3);
        $segments_4 = $this->getInputByLen($input, 4);

        $segments_1 = str_split($segments_1[0]);
        $segments_4 = str_split($segments_4[0]);
        $segments_7 = str_split($segments_7[0]);


        $map[0] = (array_diff($segments_7, $segments_1));
        

        $numbers_with_6_segments = $this->getInputByLen($input, 6);
        $numbers_with_5_segments = $this->getInputByLen($input, 5);

        $almost_9 = array_unique(array_merge($segments_4, $segments_7));
        asort($almost_9);
        foreach ($numbers_with_6_segments as $key => $number) {
            $number = str_split($number);
            asort($number);
            $diff = array_diff($number, $almost_9);
            if (count($diff) === 1) {
                $map[6] = $diff;
                break;
            }
            
        }
        
        $figure_8   = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
        $almost_8   = array_unique(array_merge($segments_4, $segments_7, $map[6]));
        $map[4]     = array_diff($figure_8, $almost_8);
        
        $almost_0   = array_unique(array_merge($segments_7, $map[4], $map[6]));
        asort($almost_0);
        foreach ($numbers_with_6_segments as $key => $number) {
            $number = str_split($number);
            asort($number);
            $diff = array_diff($number, $almost_0);
            if (count($diff) === 1) {
                $map[1] = $diff;
                break;
            }   
        }

        $figure_8   = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
        $almost_8   = array_unique(array_merge($almost_0, $map[1]));
        $map[3]     = array_diff($figure_8, $almost_8);


        $almost_2   = array_unique(array_merge($map[0], $map[3], $map[4], $map[6]));
        asort($almost_2);
        foreach ($numbers_with_5_segments as $key => $number) {
            $number = str_split($number);
            asort($number);
            $diff = array_diff($number, $almost_2);
            if (count($diff) === 1) {
                $map[2] = $diff;
                break;
            }   
        }

        
        $map[5]     = array_diff($segments_1, $map[2]);

        foreach($map as $key => $value){
            if (is_array($value)) {
                foreach ($value as $val) {
                    $map[$key] = $val;
                }
            }
        }


        return $map;
        /*
        ab: 1
        gcdfa: 2
        fbcad: 3
        eafb: 4
        cdfbe: 5
        cdfgeb: 6
        dab: 7
        acedgfb: 8
        cefabd: 9
        cagedb: 0
        */
    }

    protected function getInputByLen(array $data, int $len):array
    {
        $result             = [];
        foreach ($data as $key => $value) {
            if (strlen($value) === $len) {
                $result[]   = $value;
            }
        }
        return $result;
    }

    protected function decode(string $value, array $map):int
    {
        $mapping = [
            '9' => [$map[0], $map[1], $map[2], $map[3], $map[5], $map[6]],
            '8' => $map,
            '7' => [$map[0], $map[2], $map[5]],
            '6' => [$map[0], $map[1], $map[3], $map[4], $map[5], $map[6]],
            '5' => [$map[0], $map[1], $map[3], $map[5], $map[6]],
            '4' => [$map[1], $map[2], $map[3], $map[5]],
            '3' => [$map[0], $map[2], $map[3], $map[5], $map[6]],
            '2' => [$map[0], $map[2], $map[3], $map[4], $map[6]],
            '1' => [$map[2], $map[5]],
            '0' => [$map[0], $map[1], $map[2], $map[4], $map[5], $map[6]],
        ];
    
        $value = str_split($value);
        asort($value);
        $a = implode('',$value);

        foreach ($mapping as $number => $segments) {
            asort($segments);
            $b = implode('',$segments);
            

            if ($a === $b) {
                return $number;
            }
        }

        return 0;    
    }
}