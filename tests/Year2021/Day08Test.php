<?php declare(strict_types=1);

use Solver\Year2021\Day08;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day08Helper extends Day08
{
    
}

final class Day08Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day08.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day08Helper($parser->getData());

        //$this->assertEquals('26', $solver->getResult(1));
        $this->assertEquals('61229', $solver->getResult(2));
    }
}