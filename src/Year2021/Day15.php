<?php

namespace Solver\Year2021;

use Exception;
use Throwable;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Day15
{
    protected array $data;
    protected array $weights = [];
    protected array $visited = [];

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
        echo "\n ### --- Day 15: Chiton Part1! --- ### \n";
        // needs a bit more memory
        ini_set('memory_limit', '1024M');
        
        $map            = $this->buildMap($this->data);

        $endx           = count($map)-1;
        $endy           = count($map[0])-1;

        $queue          = [];

        $queue[$this->getKey([0,0])] = $map[0][0]['hdistance'] + 9999999;

        $visited        = [[0,0]];
        $weights        = [];
        $weights[$this->getKey([0,0])] = 0;
        $weight         = $this->findRoute([0,0], [$endx, $endy], $map, $queue, $visited, $weights);

        return $weight;
    }

    protected function part2():string
    {
        // needs a bit more memory
        ini_set('memory_limit', '1024M');
        
        echo "\n ### --- Day 15: Chiton Part2! --- ### \n";
        $map            = $this->buildMap($this->data);
        $map            = $this->expandMap($map, 5);

        $endx           = count($map)-1;
        $endy           = count($map[0])-1;

        $queue          = [];

        $queue[$this->getKey([0,0])] = $map[0][0]['hdistance'] + 9999999;

        $visited        = [[0,0]];
        $weights        = [];
        $weights[$this->getKey([0,0])] = 0;

        $weight         = $this->findRoute([0,0], [$endx, $endy], $map, $queue, $visited, $weights);

        return $weight;
    }

    protected function expandMap(array $map, int $factor): array
    {
        $endx                   = count($map[0]);
        $endy                   = count($map);
        
        $new_x                  = $endx * $factor;
        $new_y                  = $endy * $factor;

        // expand down
        for ($i = $endy; $i < $new_y; $i++) { 
            for ($j = 0; $j < $endx; $j++) {

                $value = $map[$i-$endy][$j]['value']+1;

                if ($value>9) {
                    $value      = 1;
                }
                if(!isset($map[$i])){
                    $map[$i]    = [];
                }
                $map[$i][$j]    = [
                    'value'     => $value,
                    'hdistance' => $this->calcHdistance([$j, $i], [$new_x, $new_y]),
                ];
            }
        }

        // expand to the right 
        for ($i = 0; $i < $new_y; $i++) { 
            for ($j = $endx; $j < $new_x; $j++) {

                $value = $map[$i][$j-$endx]['value']+1;

                if ($value>9) {
                    $value = 1;
                }
                if(!isset($map[$i][$j])){
                    $map[$i][$j] = [];
                }
                $map[$i][$j] = [
                    'value'     => $value,
                    'hdistance' => $this->calcHdistance([$j, $i], [$new_x, $new_y]),
                ];
            }
        }

        // update distances
        for ($i = 0; $i < $endy; $i++) { 
            for ($j = 0; $j < $endx; $j++) {
                $map[$i][$j]['hdistance'] = $this->calcHdistance([$j, $i], [$new_x, $new_y]);
            }
        }

        return $map;
    }

    protected function buildMap(array $data): array
    {
        $map                    = [];

        $endx                   = strlen($data[0])-1;
        $endy                   = count($data)-1;

        foreach ($data as $y => $row) {
            $chars              = str_split($row);
            $values             = [];
            foreach ($chars as $x => $char) {
                $values[]       = [
                    'value'     => $char,
                    'hdistance' => $this->calcHdistance([$x, $y], [$endx, $endy]),
                ];
            }
            $map[]              = $values;
        }
        return $map;
    }

    protected function getKey(array $point): string
    {
        return 'p' . implode(':',$point);
    }

    protected function keyToCoordinates(string $key): array
    {
        [$x, $y]                = explode(':', str_replace('p', '', $key));
        return [(int)$x, (int)$y];
    }

    protected function findRoute(array $point, array $end, array $map, array $queue=[], array &$visited=[], array &$weights=[]): string
    { 
        while(!$this->done($point , $end)){

            $pointKey           = $this->getKey($point);

            unset($queue[$pointKey]);
            
            $neighbours         = $this->getNeighbours($point, $queue, $map, $visited);
            foreach ($neighbours as $neighbour) {

                $data           = $map[$neighbour[0]][$neighbour[1]];
                $nKey           = $this->getKey($neighbour);

                $visited[$nKey] = true;
                $weights[$nKey] = $weights[$pointKey] + $data['value'];

                $queue[$nKey]   = $weights[$nKey] + $data['hdistance'];
            }

            $point              = $this->getNexStep($queue);
        }

        $pointKey               = $this->getKey($point);
        return $weights[$pointKey];

    }

    protected function getNexStep(array &$queue): array
    {
        asort($queue);
        $key = array_key_first($queue);

        return $this->keyToCoordinates($key);
    }

    protected function getNeighbours(array $point, array &$queue, array &$map, array &$visited): array
    {
        [$x, $y]                = $point;
        $points                 = [
                                [$x, $y+1],
                                [$x, $y-1],
                                [$x+1, $y],
                                [$x-1,$y],
        ];

        $neighbours             = [];
        foreach ($points as $neighbour) {
            if ($this->pointToExplore($neighbour, $queue, $map, $visited)) {
                $neighbours[]   = $neighbour;
            }
        }
        
        return $neighbours;
    }

    protected function pointToExplore(array $point, array &$queue, array &$map, array &$visited)
    {
        $key                    = $this->getKey($point);
        [$x, $y]                = $point;

        return 
            isset($map[$x][$y]) 
            && !isset($queue[$key])
            && !isset($visited[$key]) ;
    }

    protected function done(array $step, array $end): bool
    {
        return $step[0] == $end[0] && $step[1] == $end[1];
    }

    protected function calcHdistance(array $from, array $till): int
    {
        return $till[0] - $from[0] + ($till[1] - $from[1]);
    }
}