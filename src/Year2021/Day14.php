<?php

namespace Solver\Year2021;

class Day14
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
        echo "\n ### --- Day 14: Extended Polymerization Part1! --- ### \n";
        [$polymer, $rules]  = $this->parseData($this->data);

        $pairs              = $this->splitIntoPairs($polymer);

        $histogram          = [];
        foreach ($pairs as $pair) {
            $histogram      = $this->sumHistograms(
                                $histogram, 
                                $this->getHistogramRecursive($pair, $rules, 0, 10)
            );
        }

        $min                = min($histogram);
        $max                = max($histogram);
        return $max - $min;
    }

    protected function part2():string
    {
        // needs a bit more memory
        ini_set('memory_limit', '2024M');

        echo "\n ### --- Day 14: Extended Polymerization Part2! --- ### \n";
        
        [$polymer, $rules]  = $this->parseData($this->data);

        $end_result         = [];
        $histograms         = [];

        // 1st grow polymer by 20 steps, not too big for memory and many duplicate pairs
        for ($i=0; $i < 20; $i++) { 
            $polymer        = $this->growPolymer($polymer, $rules);
        }

        // grow each pair separately by 20, use caching 
        $pairs              = $this->splitIntoPairs($polymer);
        foreach ($pairs as $pair) {
            if (!isset($histograms[$pair])) {
                $histograms[$pair] = $this->getHistogramRecursive($pair, $rules, 0, 20);
            }

            $end_result     = $this->sumHistograms($end_result, $histograms[$pair]);
        }

        $min                = min($end_result);
        $max                = max($end_result);
        return $max - $min;
    }

    protected function parseData(array $data): array
    {
        $start      = $data[0];
        unset($data[0]);

        $rules      = [];
        foreach ($data as $row) {
            if (!$row) {
                continue;
            }

            [$rule, $insert] = explode(' -> ', $row);
            $rules[$rule]  = $insert;
        }

        return [$start, $rules];
    }

    protected function growPolymer(string $polymer, array $rules): string
    {
        $new_polymer        = $polymer[0];
        for ($i=0; $i < strlen($polymer)-1; $i++) {
            $insert         = $rules[$polymer[$i] . $polymer[$i+1]]; 
            $new_polymer   .= $insert . $polymer[$i+1];
        }

        return $new_polymer;
    }

    protected function splitIntoPairs(string $polymer): array
    {
        $pairs = [];
        for ($i=0; $i < strlen($polymer)-1; $i++) { 
            $pairs[] = $polymer[$i].$polymer[$i+1];
        }
        return $pairs;
    }

    protected function getHistogramRecursive(string $polymer, array $rules, int $step, int $max_step): array
    {
        if ($step === $max_step) {
            $counts             = [];

            $polymerlength      = strlen($polymer);
    
            for ($i=1; $i < $polymerlength; $i++) { 
                if (!isset($counts[$polymer[$i]])) {
                    $counts[$polymer[$i]] = 0;
                }
                $counts[$polymer[$i]]++;
            }

            return $counts;
        }
       
        $left   = $this->getHistogramRecursive($polymer[0] . $rules[$polymer], $rules, $step+1, $max_step);
        $right  = $this->getHistogramRecursive($rules[$polymer] . $polymer[1], $rules, $step+1, $max_step);
        return $this->sumHistograms($left, $right);
    }

    protected function sumHistograms(array $left, array $right): array
    {
        foreach ($right as $key => $value) {
            if (!isset($left[$key])) {
                $left[$key] = 0;
            }
            $left[$key] += $value; 
        }

        return $left;
    }
}