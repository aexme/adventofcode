<?php

namespace Solver\Year2021;

use PhpParser\Node\Stmt\Foreach_;

class Day10
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
        echo "\n ### --- Day 10: Syntax Scoring Part1! --- ### \n";

        $sum            = 0;
        foreach ($this->data as $row) {
            if ($char   = $this->rowIsCorrupted($row)) {
                $sum   += $this->getScore($char);
            }
        }

        return $sum;
    }

    protected function part2():string
    {
        echo "\n ### --- Day 10: Syntax Scoring Part2! --- ### \n";

        $scores         = [];
        foreach ($this->data as $row) {
            if (!$this->rowIsCorrupted($row)) {
                $chunk  = $this->generateMissingString($row);
                $scores[] = $this->scoreChunk($chunk); 
            }
        }
        
        sort($scores);
        $middle         = round(count($scores)/2)-1;

        return $scores[$middle];
    }

    protected function getScore($char)
    {
        $map = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
        ];        
            
        return $map[$char]??0;
    }

    protected function generateMissingString(string $row):string
    {
        $data           = str_split($row);
        $open           = [];

        foreach ($data as $char) {
            
            if ($this->isCloseChar($char)) {
                
                $last   = array_key_last($open);
                if ($open[$last] === $this->getOpenChar($char)) {
                    unset($open[$last]);
                }
                
            }else{
                $open[] = $char;
            }
        }
        
        $result         = '';
        foreach ($open as $value) {
            $result    = $this->getCloseChar($value) . $result;
        }
        
        return $result;
    }

    protected function scoreChunk(string $chunk):int
    {
        $map = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];

        $data           = str_split($chunk);
        $score          = 0;
        foreach ($data as $key => $char) {
            $score      = $score * 5;
            $score     += $map[$char]??0;
        }

        return $score;
    }    

    protected function isCloseChar($char)
    {        
        return (bool)$this->getScore($char);
    }

    protected function getOpenChar($char)
    {
        $map = [
            ')' => '(',
            ']' => '[',
            '}' => '{',
            '>' => '<',
        ];        
            
        return $map[$char]??false;
    }

    protected function getCloseChar($char)
    {
        $map = [
            '(' => ')',
            '[' => ']',
            '{' => '}',
            '<' => '>',
        ];        
            
        return $map[$char]??false;
    }

    protected function rowIsCorrupted(string $row)
    {
        $data           = str_split($row);
        $open           = [];

        foreach ($data as $char) {
            
            if ($this->isCloseChar($char)) {
                
                $last   = array_key_last($open);
                if ($open[$last] === $this->getOpenChar($char)) {
                    unset($open[$last]);
                }else{
                    return $char;
                }
                
            }else{
                $open[] = $char;
            }
        }
        
        return false;
    }
}