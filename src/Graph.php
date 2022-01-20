<?php

namespace Solver;

class Graph
{
    protected array $nodes;
    protected Node $start;
    protected Node $end;

    public function __construct()
    {
        
    }

    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    public function findDistinctPaths(): array
    {
        return [];
    }
}