<?php

namespace Solver;

class InputParser
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getData():array
    {
        $data = file($this->path);
        $data = array_map('trim', $data);

        return $data;
    }
}