<?php

namespace Solver\Year2021;

class Day12
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
        $graph  = $this->createGraph($this->data);
        $paths  = $this->findPaths($graph);

        return count($paths);
    }

    protected function part2():string
    {
        // needs a bit more memory
        ini_set('memory_limit', '512M');

        echo "\n ### --- Day 12: Passage Pathing Part2! --- ### \n";
        $graph  = $this->createGraph($this->data);
        $paths  = $this->findPaths($graph, true);

        return count($paths);
    }

    protected function createGraph(array $data): array
    {
        $graph                      = [];
        foreach ($data as $value) {
            [$start, $end]          = explode('-', $value);
            
            if (!isset($graph[$start])) {
                $graph[$start]      = [];
            }

            if( !in_array($end, $graph[$start]) )
            {
                $graph[$start][]    = $end;
            }

            if (!isset($graph[$end])) {
                $graph[$end]        = [];
            }

            if( !in_array($start, $graph[$end]) )
            {
                $graph[$end][]      = $start;
            }
        }

        return $graph;
    }

    protected function findPaths(array $graph, $extended=false): array
    {
        $paths          = $this->explore('start', ['start'], $graph, [], $extended);
        return $paths;
    }

    protected function explore(string $start, array $path, array $graph, array $paths=[], $extended=false):array
    {
        if ($start === 'end') {
            $paths[]    = $path;
            return $paths;
        }

        foreach ($graph[$start] as $cave) {

            if($this->shouldNotEnterCave($cave, $path, $extended))
            {    
                continue;
            }

            $paths      = $this->explore($cave, [...$path, $cave], $graph, $paths, $extended);        
        }
        
        return $paths;
    }

    protected function shouldNotEnterCave(string $cave, array $path, $extended=false): bool
    {
        if ($extended) {
            return $this->shouldNotEnterCaveExtended($cave, $path);
        }
        return (in_array($cave, $path) && ctype_lower($cave));
    }

    protected function shouldNotEnterCaveExtended(string $cave, array $path): bool
    {
        $chars = [];
        
        // is upper case, can visit multipletimes
        if (!ctype_lower($cave)) {
            return false;
        }

        // start/end can only visit once
        if ($cave==='start' || $cave==='end') {
            return in_array($cave, $path);
        }

        foreach ($path as $cave_visited) {

            if ($cave_visited ==='start' || $cave_visited ==='end' || !ctype_lower($cave_visited)) {
                continue;
            }

            if (!isset($chars[$cave_visited])) {
                $chars[$cave_visited] = 0;
            }

            $chars[$cave_visited]++;
        }

        foreach ($chars as $count) {
            if ($count>1 && isset($chars[$cave])) {
                return true;
            }
        }

        return false;
    }
}