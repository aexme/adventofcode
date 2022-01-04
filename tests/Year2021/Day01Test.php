<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class Day01Helper extends Solver\Year2021\Day01
{
    public function publicGetSum(int $index, array $data)
    {
        return $this->getSum($index, $data);
    }
}

final class Day01Test extends TestCase
{
    public function testGetResult()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day01.example');
        $solver     = new Solver\Year2021\Day01($parser->getData());
        
        $this->assertEquals('7', $solver->getResult(1));
        $this->assertEquals('5', $solver->getResult(2));
    }

    public function testGetSum()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day01.example');
        $data       = $parser->getData();
        $solver     = new Day01Helper($data);
        
        $this->assertEquals(607, $solver->publicGetSum(0, $data));
        $this->assertEquals(792, $solver->publicGetSum(7, $data));
        $this->assertEquals(false, $solver->publicGetSum(8, $data));
    }
}