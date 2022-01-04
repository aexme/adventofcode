<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Day02Test extends TestCase
{
    public function testGetResult()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day02.example');
        $solver     = new Solver\Year2021\Day02($parser->getData());

        $this->assertEquals('150', $solver->getResult(1));
        $this->assertEquals('900', $solver->getResult(2));
    }
}