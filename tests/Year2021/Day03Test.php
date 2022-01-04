<?php declare(strict_types=1);

use Solver\Year2021\Day03;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day03Helper extends Day03
{
    public function publicOxygenRating():int
    {
        return $this->oxygenRating();
    }

    public function publicGetCo2Rating():int
    {
        return $this->getCo2Rating();
    }

    public function publicGetRowsWithValue(array $data, int $value, int $collumn):array
    {
        return $this->getRowsWithValue($data, $value, $collumn);
    }

    public function publicCountOnesInCollumn(array $data, int $collumn):int
    {
        return $this->countOnesInCollumn($data, $collumn);
    }

    public function publicGetMostCommonValue(array $data, int $collumn):int
    {        
        return $this->getMostCommonValue($data, $collumn);
    }

    public function publicGetLeastCommonValue(array $data, int $collumn):int
    {   
        return $this->getLeastCommonValue($data, $collumn);
    }
}

final class Day03Test extends TestCase
{
    public function testGetResult()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day03.example');
        $solver     = new Day03Helper($parser->getData());

        $this->assertEquals('198', $solver->getResult(1));
        $this->assertEquals('230', $solver->getResult(2));
    }

    public function testOxygenRating()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day03.example');
        $solver     = new Day03Helper($parser->getData());

        $this->assertEquals('23', $solver->publicOxygenRating());
    }

    public function testCo2Rating()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day03.example');
        $solver     = new Day03Helper($parser->getData());

        $this->assertEquals('10', $solver->publicGetCo2Rating());
    }

    public function testGetRowsWithValue()
    {
        $solver     = new Day03Helper([]);

        $data       = [
                    '1001',
                    '0110',
        ];

        $result     = $solver->publicGetRowsWithValue($data, 1, 2);
        $this->assertContains('0110', $result);
        $this->assertCount(1, $result);

        $result     = $solver->publicGetRowsWithValue($data, 0, 2);
        $this->assertContains('1001', $result);
        $this->assertCount(1, $result);
    }

    public function testCountOnesInCollumn()
    {
        $solver     = new Day03Helper([]);

        $data       = [
                    '1001',
                    '1101',
                    '0101',
        ];

        $this->assertEquals(2, $solver->publicCountOnesInCollumn($data, 0));
        $this->assertEquals(3, $solver->publicCountOnesInCollumn($data, 3));
        $this->assertEquals(0, $solver->publicCountOnesInCollumn($data, 2));
    }

    public function testGetLeastCommonValue()
    {
        $solver     = new Day03Helper([]);

        $data       = [
                    '1001',
                    '1101',
                    '0101',
                    '0101',
        ];

        $this->assertEquals(0, $solver->publicGetLeastCommonValue($data, 0));
        $this->assertEquals(0, $solver->publicGetLeastCommonValue($data, 1));
        $this->assertEquals(1, $solver->publicGetLeastCommonValue($data, 2));
        $this->assertEquals(0, $solver->publicGetLeastCommonValue($data, 3));
    }

    public function testGetMostCommonValue()
    {
        $solver     = new Day03Helper([]);

        $data       = [
                    '1001',
                    '1100',
                    '0100',
                    '0100',
        ];

        $this->assertEquals(1, $solver->publicGetMostCommonValue($data, 0));
        $this->assertEquals(1, $solver->publicGetMostCommonValue($data, 1));
        $this->assertEquals(0, $solver->publicGetMostCommonValue($data, 2));
        $this->assertEquals(0, $solver->publicGetMostCommonValue($data, 3));
    }
}