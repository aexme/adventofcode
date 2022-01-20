<?php declare(strict_types=1);

use Solver\Year2021\Day12;
use PHPUnit\Framework\TestCase;

class TestHelper12 extends Day12
{
    public function public_createGraph($data)
    {
        return $this->createGraph($data);
    }

    public function public_explore($start, $path, $graph, $paths=[])
    {
        return $this->explore($start, $path, $graph, $paths);
    }


    public function public_shouldNotEnterCaveExtended(string $cave, array $path)
    {
        return $this->shouldNotEnterCaveExtended($cave, $path);
    }
    
}

final class Day12Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day12.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper12($parser->getData());

        $this->assertEquals('226', $solver->getResult(1));
        $this->assertEquals('3509', $solver->getResult(2));
    }

    public function test_createGraph(){

        $data = [
            'start-A',
            'start-b',
            'A-c',
            'A-b',
            'b-d',
            'A-end',
            'b-end',
        ];

        $solver     = new TestHelper12([]);
        $graph      = $solver->public_createGraph($data);

        $this->assertIsArray($graph);
        $this->assertEquals(['A', 'b'], $graph['start']);
        $this->assertEquals(['start', 'c', 'b',  'end'], $graph['A']);
        $this->assertEquals(['A', 'b'], $graph['end']);
    }

    public function test_explore(){

        $data = [
            'start-A',
            'start-b',
            'A-c',
            'A-b',
            'b-d',
            'A-end',
            'b-end',
        ];

        $expected = [
            'start,A,b,A,c,A,end',
            'start,A,b,A,end',
            'start,A,b,end',
            'start,A,c,A,b,A,end',
            'start,A,c,A,b,end',
            'start,A,c,A,end',
            'start,A,end',
            'start,b,A,c,A,end',
            'start,b,A,end',
            'start,b,end',
        ];

        $solver     = new TestHelper12($data);
        $graph      = $solver->public_createGraph($data);

        $paths      = $solver->public_explore('start', ['start'], $graph);
        foreach ($paths as $key => $value) {
            $paths[$key] = implode(',', $value);
        } 

        $this->assertIsArray($paths);
        $this->assertCount(10, $paths);
        $this->assertContains($expected[0], $paths);
        $this->assertContains($expected[1], $paths);
        $this->assertContains($expected[0], $paths);
        $this->assertContains($expected[9], $paths);
    }

    public function test_shouldNotEnterCaveExtended()
    {
        $solver     = new TestHelper12([]);

        $this->assertTrue($solver->public_shouldNotEnterCaveExtended('c', ['start', 'A', 'c', 'A', 'c', 'A']));

        $this->assertFalse($solver->public_shouldNotEnterCaveExtended('b', ['start', 'A', 'c', 'A', 'c', 'A']));
        $this->assertTrue($solver->public_shouldNotEnterCaveExtended('b', ['start', 'A', 'c', 'A', 'c', 'A', 'b']));
    }
}