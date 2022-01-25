<?php declare(strict_types=1);

use Solver\Year2021\Day13;
use PHPUnit\Framework\TestCase;

class TestHelper13 extends Day13
{
    public function public_fold($map, $instruction)
    {
        return $this->fold($map, $instruction);
    }   

    public function public_buildMap($points)
    {
        return $this->buildMap($points);
    }   

    public function public_fillMap($map, $points)
    {
        return $this->fillMap($map, $points);
    }   

    public function public_countPoints($map)
    {
        return $this->countPoints($map);
    }
    
    public function public_parseData($data)
    {
        return $this->parseData($data);
    } 
    
    public function public_getMapDimensions($points)
    {
        return $this->getMapDimensions($points);
    }   
}

final class Day13Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day13.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper13($parser->getData());

        $this->assertEquals('17', $solver->getResult(1));
    }

    public function test_countPoints()
    {
        $solver     = new TestHelper13([]);

        $this->assertEquals(2, $solver->public_countPoints([[0,0,1],[1,0,0]]));
        $this->assertEquals(0, $solver->public_countPoints([[0,0,0],[0,0,0]]));
        $this->assertEquals(9, $solver->public_countPoints([[1,1,1],[1,1,1],[1,1,1]]));
    }

    public function test_parseData()
    {
        $solver                  = new TestHelper13([]);
        $data                    = [
            '0,5',
            '8,9',
            '',
            'fold along y=7',
            'fold along x=5',
        ];

        [$points, $instructions] = $solver->public_parseData($data);

        $this->assertEquals([0,5], $points[0]);
        $this->assertEquals([8,9], $points[1]);
        $this->assertEquals(['y','7'], $instructions[0]);
        $this->assertEquals(['x','5'], $instructions[1]);

        $this->assertCount(2, $points);
        $this->assertCount(2, $instructions);
    }

    public function test_fillMap()
    {
        $solver         = new TestHelper13([]);
        $points         = [
            [0,3],
            [3,3],
        ];

        $map            = [
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0],
        ];

        $map            = $solver->public_fillMap($map, $points);

        $this->assertEquals(0, $map[0][0]);
        $this->assertEquals(1, $map[3][0]);
        $this->assertEquals(1, $map[3][3]);
        
        $this->assertCount(4, $map);
        $this->assertCount(4, $map[0]);
    }


    public function test_getMapDimensions()
    {
        $solver         = new TestHelper13([]);
        $points         = [
            [0,3],
            [3,3],
        ];

        [$rows, $cols] = $solver->public_getMapDimensions($points);

        $this->assertEquals(3, $rows);
        $this->assertEquals(3, $cols);
    }

    public function test_buildMap()
    {
        $solver         = new TestHelper13([]);
        $points         = [
            [6,10],
            [0,14],
            [9,10],
            [0,3],
            [10,4],
            [4,11],
            [6,0],
            [6,12],
            [4,1],
            [0,13],
            [10,12],
            [3,4],
            [3,0],
            [8,4],
            [1,10],
            [2,14],
            [8,10],
            [9,0],
        ];

        $map            = $solver->public_buildMap($points);

        $this->assertEquals(1, $map[0][3]);
        $this->assertEquals(1, $map[10][6]);
        $this->assertEquals(0, $map[0][0]);
        
        $this->assertCount(15, $map);
        $this->assertCount(11, $map[0]);
    }

    public function test_fold()
    {
        $solver         = new TestHelper13([]);
        $map            = [
            [0,1,0,0,0],
            [0,0,0,1,0],
            [0,0,0,0,0],
            [1,0,0,0,0],
            [0,1,0,0,0],
        ];

        $result         = [
            [0,1,0,0,0],
            [1,0,0,1,0]
        ];
        $instruction    = ['y', '2'];
        $map            = $solver->public_fold($map, $instruction);

        $this->assertEquals($result, $map);

        $map            = [
            [0,1,0,0,0],
            [0,0,0,1,0],
            [0,0,0,0,0],
            [1,0,0,0,0],
            [0,1,0,0,0],
        ];

        $result         = [
            [0,1],
            [0,1],
            [0,0],
            [1,0],
            [0,1],
        ];
        $instruction    = ['x', '2'];
        $map            = $solver->public_fold($map, $instruction);

        $this->assertEquals($result, $map);
    }
}