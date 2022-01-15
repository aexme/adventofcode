<?php declare(strict_types=1);

use Solver\Year2021\Day11;
use PHPUnit\Framework\TestCase;
use TestHelper as GlobalTestHelper;

class TestHelper extends Day11
{
    public function public_containsRipeOctopy(array $matrix)
    {
        return $this->containsRipeOctopy($matrix);
    }
    public function public_doFlashing(array $matrix):array
    {
        return $this->doFlashing($matrix);
    }
    public function public_resetFlashCount(array $matrix):array
    {
        return $this->resetFlashCount($matrix);
    }
    public function public_doFlash($point, $matrix)
    {
        return $this->doFlash($point, $matrix);
    }
    public function public_shouldFlash($point, $matrix)
    {
        return $this->shouldFlash($point, $matrix);
    }
    public function public_isOut($point, $matrix)
    {
        return $this->isOut($point, $matrix);
    }
    public function public_parseData(array $data):array
    {
        return $this->parseData($data);
    }
    public function public_increaseAll(array $matrix):array
    {
        return $this->increaseAll($matrix);
    }
    public function public_increaseOne(array $point, array $matrix): array
    {
        return $this->increaseOne($point, $matrix);
    }

    public function public_isRipe($value): bool
    {
        return $this->isRipe($value);
    }

    public function public_matrixAllZero($matrix): bool
    {
        return $this->matrixAllZero($matrix);
    }
}

final class Day11Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day11.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper($parser->getData());

        $this->assertEquals('1656', $solver->getResult(1));
        $this->assertEquals('195', $solver->getResult(2));
    }

    public function test_containsRipeOctopy()
    {
        $handler = new TestHelper([]);
        $data       = [
            [0,1,9],
            [1,1,'f'],
            [1,9,4]
        ];

        $this->assertFalse($handler->public_containsRipeOctopy($data));
        
        $data       = [
            [0,1,9],
            [1,1,'f'],
            [1,10,4]
        ];
        $this->assertTrue($handler->public_containsRipeOctopy($data));
    }
    
    public function test_doFlashing()
    {
        $handler    = new TestHelper([]);
        $data       = [
            [2,2,2,2,2],
            [2,10,10,10,2],
            [2,10,2,10,2],
            [2,10,10,10,2],
            [2,2,2,2,2],
        ];

        $expected   = [
            [3,4,5,4,3],
            [4,0,0,0,4],
            [5,0,0,0,5],
            [4,0,0,0,4],
            [3,4,5,4,3],
        ];

        $res        = $handler->public_doFlashing($data);

        $this->assertEquals(9, $res[0]);
        $this->assertEquals($expected, $res[1]);
    }
    
    public function test_resetFlashCount()
    {
        $handler     = new TestHelper([]);
        $data       = [
            [0,1,9],
            [1,1,'f'],
            [1,'f',4]
        ];

        $expected   = [
            [0,1,9],
            [1,1,0],
            [1,0,4]
        ];
        $res        = $handler->public_resetFlashCount($data);

        $this->assertIsArray($res);
        $this->assertEquals($expected, $res);
    }
    
    public function test_matrixAllZero()
    {
        $handler     = new TestHelper([]);
        $data1       = [
            [0,0,0],
            [0,0,0],
            [0,0,0]
        ];

        $data2      = [
            [0,1,9],
            [1,1,0],
            [1,0,4]
        ];
        $this->assertTrue($handler->public_matrixAllZero($data1));
        $this->assertFalse($handler->public_matrixAllZero($data2));
    }

    public function test_doFlash()
    {
        $handler    = new TestHelper([]);
        $data       = [
            [0,1,9],
            [1,1,10],
            [1,10,4]
        ];

        $expected   = [
            [0,2,10],
            [1,2,'f'],
            [1,11,5]
        ];
        $res        = $handler->public_doFlash([1,2], $data);

        $this->assertIsArray($res);
        $this->assertEquals($expected, $res[1]);
    }
    
    public function test_shouldFlash()
    {
        $handler = new TestHelper([]);
        
        $data       = [
            [0,1,9],
            [1,1,'f'],
            [1,10,4]
        ];
        $this->assertFalse($handler->public_shouldFlash([0,2], $data));
        $this->assertFalse($handler->public_shouldFlash([1,2], $data));
        $this->assertFalse($handler->public_shouldFlash([0,0], $data));

        $this->assertTrue($handler->public_shouldFlash([2,1], $data));
    }
    
    public function test_isOut()
    {
        $handler    = new TestHelper([]);
        $data       = [
            [0,1],
            [1,1]
        ];
        
        $this->assertFalse($handler->public_isOut([0,0], $data));
        $this->assertFalse($handler->public_isOut([1,1], $data));

        $this->assertTrue($handler->public_isOut([2,1], $data));
        $this->assertTrue($handler->public_isOut([-1,0], $data));
        $this->assertTrue($handler->public_isOut([0,-1], $data));
    }
    
    public function test_parseData()
    {
        $handler = new TestHelper([]);
        $data = [
            '11111',
            '19991',
            '19191',
            '19991',
            '11111',
        ];
        $res = $handler->public_parseData($data);
        $this->assertIsArray($res);
        $this->assertIsArray($res[0]);
        $this->assertCount(5, $res[0]);
        $this->assertEquals([1,1,1,1,1], $res[0]);
    }
    
    public function test_increaseAll()
    {
        $handler    = new TestHelper([]);
        $data       = [
            [0,1],
            [1,1]
        ];

        $expected   = [
            [1,2],
            [2,2]
        ];

        $data       = $handler->public_increaseAll($data);
        $this->assertEquals($expected, $data);
    }
    
    public function test_increaseOne()
    {
        $handler    = new TestHelper([]);
        $data       = [
            [0,1],
            [1,1]
        ];

        $expected   = [
            [0,2],
            [1,2]
        ];


        $data       = $handler->public_increaseOne([0,1], $data);
        $data       = $handler->public_increaseOne([1,1], $data);
        $this->assertEquals($expected, $data);
    }

    public function test_isRipe()
    {
        $handler = new TestHelper([]);
        $this->assertFalse($handler->public_isRipe(4));
        $this->assertFalse($handler->public_isRipe('f'));
        $this->assertFalse($handler->public_isRipe(0));
        $this->assertTrue($handler->public_isRipe(10));
        $this->assertTrue($handler->public_isRipe(999));
    }
}