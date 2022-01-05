<?php declare(strict_types=1);

use Solver\Year2021\Day05;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day05Helper extends Day05
{
    
    public function publicGetMapDimensions()
    {
        return $this->getMapDimensions();
    }

    public function publicParseInputRow(string $row)
    {
        return $this->parseInputRow($row);
    }

    public function publicBuildMap()
    {
        return $this->buildMap();
    }

    public function publicFillCollumn(array $map, array $start, array $end)
    {
        return $this->fillCollumn($map, $start, $end);
    }

    public function publicFillRow(array $map, array $start, array $end)
    {
        return $this->fillRow($map, $start, $end);
    }

    public function publicFillDiagonal(array $map, array $start, array $end)
    {
        return $this->fillDiagonal($map, $start, $end);
    }
}

final class Day05Test extends TestCase
{

    protected $data_path = __DIR__ .'/data/day05.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day05Helper($parser->getData());

        $this->assertEquals('5', $solver->getResult(1));
        $this->assertEquals('12', $solver->getResult(2));
    }

    public function testParseInputRow()
    {
        $solver     = new Day05Helper([]);

        [[$start_x, $start_y], [$end_x, $end_y]] = $solver->publicParseInputRow('5,7 -> 8,2');

        $this->assertEquals(5, $start_x);
        $this->assertEquals(7, $start_y);
        $this->assertEquals(8, $end_x);
        $this->assertEquals(2, $end_y);

        [[$start_x, $start_y], [$end_x, $end_y]] = $solver->publicParseInputRow('4,2 -> 2,1');
        
        $this->assertEquals(4, $start_x);
        $this->assertEquals(2, $start_y);
        $this->assertEquals(2, $end_x);
        $this->assertEquals(1, $end_y);
    }

    public function testGetMapDimensions()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day05Helper($parser->getData());

        [$x, $y]    = $solver->publicGetMapDimensions();

        $this->assertEquals(9, $x);
        $this->assertEquals(9, $y);
    }

    public function testBuildMap()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day05Helper($parser->getData());

        $map        = $solver->publicBuildMap();

        $this->assertIsArray($map);

        $this->assertCount(10, $map);
        $this->assertCount(10, $map[0]);

        $this->assertEquals(2, $map[9][0]);
        $this->assertEquals(1, $map[9][3]);
        $this->assertEquals(0, $map[0][0]);
        $this->assertEquals(0, $map[0][6]);
    }

    public function testFillRow()
    {
        $data       = ['0,0 -> 9,9'];
        $solver     = new Day05Helper($data);

        // testing left right filling
        $map        = $solver->publicBuildMap();
        $start      = [0,9];
        $end        = [5,9];
        $map        = $solver->publicFillRow($map, $start, $end);

        $this->assertIsArray($map);
        $this->assertEquals(1, $map[9][0]);
        $this->assertEquals(1, $map[9][5]);

        // testing increasing number
        $start      = [0,9];
        $end        = [2,9];
        $map        = $solver->publicFillRow($map, $start, $end);

        $this->assertEquals(2, $map[9][0]);
        $this->assertEquals(2, $map[9][2]);
        $this->assertEquals(1, $map[9][3]);
        $this->assertEquals(1, $map[9][5]);

        // testing right left filling
        $start      = [7,9];
        $end        = [2,9];
        $map        = $solver->publicFillRow($map, $start, $end);

        $this->assertEquals(2, $map[9][0]);
        $this->assertEquals(3, $map[9][2]);
        $this->assertEquals(1, $map[9][7]);
    }

    public function testFillCollumn()
    {        
        $data       = ['0,0 -> 9,9'];
        $solver     = new Day05Helper($data);

        $map        = $solver->publicBuildMap();
        $start      = [1,1];
        $end        = [1,3];
        $map        = $solver->publicFillCollumn($map, $start, $end);

        $this->assertIsArray($map);
        $this->assertEquals(1, $map[1][1]);
        $this->assertEquals(1, $map[3][1]);
        $this->assertEquals(0, $map[4][1]);
        
        $start      = [1,3];
        $end        = [1,8];
        $map        = $solver->publicFillCollumn($map, $start, $end);

        $this->assertEquals(2, $map[3][1]);
        $this->assertEquals(1, $map[8][1]);
        $this->assertEquals(0, $map[9][1]);
    }

    public function testFillDiagonal()
    {        
        $data       = ['0,0 -> 9,9'];
        $solver     = new Day05Helper($data);

        $map        = $solver->publicBuildMap();
        $start      = [1,1];
        $end        = [3,3];
        $map        = $solver->publicFillDiagonal($map, $start, $end);

        $this->assertIsArray($map);
        $this->assertEquals(1, $map[1][1]);
        $this->assertEquals(1, $map[3][3]);
        $this->assertEquals(0, $map[4][1]);
        
        $start      = [5,1];
        $end        = [3,3];
        $map        = $solver->publicFillDiagonal($map, $start, $end);

        $this->assertEquals(2, $map[3][3]);
        $this->assertEquals(1, $map[1][5]);
        $this->assertEquals(0, $map[1][9]);
    }
}