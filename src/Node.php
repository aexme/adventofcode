<?php

namespace Solver;

class Node
{
    protected array $size; 
    protected array $neighbors;
    
    public function __construct($size)
    {
        $this->size = $size;
    }

    public function neighbor(Node $node)
    {
        $this->neighbors[] = $node;
    }
}