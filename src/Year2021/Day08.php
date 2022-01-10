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

        $count                  = 0;

        foreach ($this->data as $key => $row) {
            [$input, $output]   = $this->parseRow($row);
            foreach ($output as $value) {
                
                $value_len      = strlen($value);
                $len_to_count   = [2,3,4,7];

                if (in_array($value_len, $len_to_count)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 8: Seven Segment Search Part2! --- ### \n"; 

        $sum                    = 0;
        foreach ($this->data as $row) {
            [$input, $output]   = $this->parseRow($row);
            
            $map                = $this->generateMap($input);
            $number             = '';
            foreach ($output as $value) {
                $number        .= $this->decode($value, $map);
            }

            $sum               += $number;
        }

        return $sum;
    }

    protected function parseRow($row):array
    {
        [$input, $output] = array_map('trim', explode('|', $row));

        return [explode(' ', $input), explode(' ', $output)];
    }

    protected function generateMap(array $input)
    {
        $map = [
                0 => false,
        1 => false,     2 => false,
                3 => false,
        4 => false,     5 => false,
                6 => false,
        ];

        $segments_1 = $this->getInputByLen($input, 2);
        $segments_7 = $this->getInputByLen($input, 3);
        $segments_4 = $this->getInputByLen($input, 4);

        $segments_1 = str_split($segments_1[0]);
        $segments_4 = str_split($segments_4[0]);
        $segments_7 = str_split($segments_7[0]);

        // get segment #0 by finding the char that is not in number 1 but in number 7
        $map[0]     = implode('', (array_diff($segments_7, $segments_1)));
        
        $numbers_with_6_segments = $this->getInputByLen($input, 6);
        $numbers_with_5_segments = $this->getInputByLen($input, 5);

        // building the number 9 with segment #6 misssing
        $almost_9   = array_unique(array_merge($segments_4, $segments_7));
        // get bottom segment going over all 6 segment numbers, find the one that is different by segment
        // that one segment is the segment #6
        $map[6]     = $this->findMissingChar($numbers_with_6_segments, $almost_9);
        
        $figure_8   = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
        // merge the segments for number 7 + 4 and #6
        // the one mising will be the segment #4
        $almost_8   = array_unique(array_merge($segments_4, $segments_7, [$map[6]]));
        $map[4]     = implode('', array_diff($figure_8, $almost_8));
        
        // merge the segments for number 7 with #6 segment and #4 segment
        // find the number with one differing segment, that will be number 0, the differing segment is #1
        $almost_0   = array_merge($segments_7, [$map[4]], [$map[6]]);
        $map[1]     = $this->findMissingChar($numbers_with_6_segments, $almost_0);

        $almost_8   = array_merge($almost_0, [$map[1]]);
        $map[3]     = implode('', array_diff($figure_8, $almost_8));

        $almost_2   = [$map[0], $map[3], $map[4], $map[6]];
        $map[2]     = $this->findMissingChar($numbers_with_5_segments, $almost_2);

        $map[5]     = implode('', array_diff($segments_1, [$map[2]]));

        return $map;
    }

    protected function findMissingChar($list, $to_exclude):string
    {
        $result     = '';
        asort($to_exclude);
        foreach ($list as $key => $number) {
            $number = str_split($number);
            asort($number);

            $diff   = array_diff($number, $to_exclude);

            if (count($diff) === 1) {
                $result = implode('', $diff);
                break;
            }   
        }

        return $result;
    }

    protected function getInputByLen(array $data, int $len):array
    {
        $result             = [];
        foreach ($data as $value) {
            if (strlen($value) === $len) {
                $result[]   = $value;
            }
        }
        return $result;
    }

    // sort input convert to string, build string for each number from map, return comparison
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
    
        $value          = str_split($value);
        asort($value);
        $number_string  = implode('',$value);

        foreach ($mapping as $number => $segments) {
            asort($segments);
            $map_string = implode('', $segments);
            
            if ($number_string === $map_string) {
                return $number;
            }
        }

        return 0;    
    }
}