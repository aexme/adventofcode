<?php declare(strict_types=1);

use Solver\Year2021\Day06;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day06Helper extends Day06
{
    
}

final class Day06Test extends TestCase
{

    protected $data_path = __DIR__ .'/data/day06.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day06Helper($parser->getData());

        $this->assertEquals('5934', $solver->getResult(1));
        $this->assertEquals('26984457539', $solver->getResult(2));
    }
}