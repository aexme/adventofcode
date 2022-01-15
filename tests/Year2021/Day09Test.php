<?php declare(strict_types=1);

use Solver\Year2021\Day09;
use PHPUnit\Framework\TestCase;

class Day09Helper extends Day09
{
    public function publicBuildMatrix(array $data)
    {
        return $this->buildMatrix($data);
    }

    public function publicGetLowpoints(array $data)
    {
        return $this->getLowpoints($data);
    }
    
    public function publicGetBasinSize(array $data)
    {
        return $this->getBasinSize($data);
    }
        
    public function publicExplore(array $point, array $matrix)
    {
        return $this->explore($point, $matrix);
    }
}

final class Day09Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day09.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day09Helper($parser->getData());

        $this->assertEquals('15', $solver->getResult(1));
        $this->assertEquals('1134', $solver->getResult(2));
    }

    public function testBuildMatrix()
    {
        $solver     = new Day09Helper([]);

        $data       = [
            '123',
            '456',
            '789',
        ];

        $matrix     = $solver->publicBuildMatrix($data);
        $this->assertIsArray($matrix);
        
        $this->assertCount(3, $matrix);
        $this->assertCount(3, $matrix[0]);
    }

    public function testGetLowpoints()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day09Helper($parser->getData());
        $matrix     = $solver->publicBuildMatrix($parser->getData());
        $lowpoints  = $solver->publicGetLowpoints($matrix);
        
        $this->assertEquals([0,1], $lowpoints[0]);
        $this->assertEquals([0,9], $lowpoints[1]);
        $this->assertEquals([2,2], $lowpoints[2]);
        $this->assertEquals([4,6], $lowpoints[3]);
        $this->assertCount(4, $lowpoints);
    }

    public function testGetBasinSize()
    {
        $data       = [
            [1,1,0],
            [1,0,0],
            [0,0,0],
        ];

        $solver     = new Day09Helper([]);
        $size       = $solver->publicGetBasinSize($data);
        
        $this->assertEquals(3, $size);
    }

    public function testExplore()
    {
        $matrix     = [
            [9,1,9],
            [2,0,9],
            [9,1,1],
        ];

        $point      = [1,1];

        $solver     = new Day09Helper([]);
        $matrix     = $solver->publicExplore($point, $matrix);
        
        $this->assertEquals('x', $matrix[0][1]);
        $this->assertEquals('x', $matrix[1][0]);
        $this->assertEquals('x', $matrix[1][1]);
        $this->assertEquals('x', $matrix[2][1]);
        $this->assertEquals('x', $matrix[2][2]);
    }
}