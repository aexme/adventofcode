<?php declare(strict_types=1);

use Solver\Year2021\Day15;
use PHPUnit\Framework\TestCase;

class TestHelper15 extends Day15
{
    public function public_buildMap(array $data)
    {
        return $this->buildMap($data);
    }

    
    public function public_expandMap(array $map, int $factor)
    {
        return $this->expandMap($map, $factor);
    }

    public function public_getKey(array $point)
    {
        return $this->getKey($point);
    }

    public function public_keyToCoordinates(string $key)
    {
        return $this->keyToCoordinates($key);
    }


    public function public_getNexStep(array $queue)
    {
        return $this->getNexStep($queue);
    }

    public function public_getNeighbours(array $point, array &$queue, array &$map, array &$visited)
    {
        return $this->getNeighbours($point, $queue, $map, $visited);
    }

    public function public_pointToExplore(array $point, array &$queue, array &$map, array &$visited)
    {
        return $this->pointToExplore($point, $queue, $map, $visited);
    }

    public function public_done(array $step, array $end)
    {
        return $this->done($step, $end);
    }

    public function public_calcHdistance($from, $till)
    {
        return $this->calcHdistance($from, $till);
    }
}

final class Day15Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day15.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper15($parser->getData());

        $this->assertEquals('40', $solver->getResult(1));
        $this->assertEquals('315', $solver->getResult(2));
    }

    public function test_buildMap()
    {
        $solver     = new TestHelper15([]);
        $data       = ['123','456','789'];
        $map        = $solver->public_buildMap($data);
        
        $this->assertCount(3, $map);
        $this->assertCount(3, $map[0]);
        $this->assertEquals(1, $map[0][0]['value']);
        $this->assertEquals(2, $map[0][1]['value']);
        $this->assertEquals(9, $map[2][2]['value']);
    }
    
    public function test_expandMap()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper15($parser->getData());
        $data       = ['123','456','789'];
        $map        = $solver->public_buildMap($data);

        $map        = $solver->public_expandMap($map, 2);
        
        $this->assertCount(6, $map);
        $this->assertCount(6, $map[0]);
        $this->assertEquals(1, $map[0][0]['value']);
        $this->assertEquals(2, $map[0][1]['value']);
        $this->assertEquals(9, $map[2][2]['value']);
        $this->assertEquals(1, $map[2][5]['value']);
        $this->assertEquals(2, $map[3][0]['value']);
        $this->assertEquals(3, $map[3][1]['value']);
        $this->assertEquals(2, $map[5][5]['value']);
    }
    
    public function test_getKey()
    {
        $solver     = new TestHelper15([]);

        $key        = $solver->public_getKey([1,4]);
        $this->assertEquals('p1:4', $key);

        $key       = $solver->public_getKey([7,8]);
        $this->assertEquals('p7:8', $key);
    }
    
    public function test_keyToCoordinates()
    {
        $solver     = new TestHelper15([]);

        $point      = $solver->public_keyToCoordinates('p3:4');
        $this->assertEquals([3,4], $point);
        $point      = $solver->public_keyToCoordinates('p1:4');
        $this->assertEquals([1,4], $point);
    }
    
    public function test_getNexStep()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper15($parser->getData());

        $queue      = ['p0:1'=>10, 'p0:2'=>15, 'p2:1'=>5]; 

        $step       = $solver->public_getNexStep($queue);
        $this->assertEquals([2,1], $step);

        $queue      = ['p2:8'=>4, 'p0:1'=>10, 'p0:2'=>15, 'p2:1'=>5]; 
        $step       = $solver->public_getNexStep($queue);
        $this->assertEquals([2,8], $step);
    }
    
    public function test_getNeighbours()
    {
        $solver     = new TestHelper15([]);

        $point      = [2,1]; 
        $queue      = ['p0:1'=>1, 'p0:2'=>1]; 
        $map        = [ [1,1,1],
                        [1,1,1], 
                        [1,1,1]
                    ]; 
        $visited    = ['p0:0'=>1, 'p1:1'=>1];

        $neighpours = $solver->public_getNeighbours($point, $queue, $map, $visited);
        $this->assertContains([2,0], $neighpours);
        $this->assertContains([2,2], $neighpours);

    }
    
    public function test_pointToExplore()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper15($parser->getData());

        $point      = [2,1]; 
        $queue      = ['p0:1'=>1, 'p0:2'=>1]; 
        $map        = [[1,1,1],[1,1,1], [1,1,1]]; 
        $visited    = ['p0:0'=>1, 'p1:1'=>1];

        $res        = $solver->public_pointToExplore($point, $queue, $map, $visited);
        $this->assertTrue($res);


        $point      = [2,1]; 
        $queue      = ['p0:1'=>1, 'p0:2'=>1, 'p2:1'=>1]; 
        $res        = $solver->public_pointToExplore($point, $queue, $map, $visited);
        $this->assertFalse($res);

        $point      = [3,1]; 
        $res        = $solver->public_pointToExplore($point, $queue, $map, $visited);
        $this->assertFalse($res);

        $point      = [1,1]; 
        $res        = $solver->public_pointToExplore($point, $queue, $map, $visited);
        $this->assertFalse($res);
    }
    
    public function test_done()
    {
        $solver     = new TestHelper15([]);

        $from       = [0,9];
        $till       = [9,9];
        $done       = $solver->public_done($from, $till);
        $this->assertFalse($done);

        $from       = [9,9];
        $till       = [9,9];
        $done       = $solver->public_done($from, $till);
        $this->assertTrue($done);
    }
    
    public function test_calcHdistance()
    {
        $solver     = new TestHelper15([]);

        $from       = [0,0];
        $till       = [9,9];
        $distance   = $solver->public_calcHdistance($from, $till);
        $this->assertEquals('18', $distance);

        $from       = [5,0];
        $till       = [9,9];
        $distance   = $solver->public_calcHdistance($from, $till);
        $this->assertEquals('13', $distance);
    }
    
}