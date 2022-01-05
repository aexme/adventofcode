<?php declare(strict_types=1);

use Solver\Year2021\Day07;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day07Helper extends Day07
{
    
    public function publicGetLimitPositions(array $data)
    {
        return $this->getLimitPositions($data);
    }
}

final class Day07Test extends TestCase
{

    protected $data_path = __DIR__ .'/data/day07.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day07Helper($parser->getData());

        $this->assertEquals('37', $solver->getResult(1));
        $this->assertEquals('168', $solver->getResult(2));
    }


    public function testGetLimitPositions()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day07Helper($parser->getData());

        [$max, $min]    = $solver->publicGetLimitPositions([5,7,10,20,4,45]);

        $this->assertEquals(45, $max);
        $this->assertEquals(4, $min);
    }
    
    
}