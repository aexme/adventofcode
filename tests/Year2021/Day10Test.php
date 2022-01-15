<?php declare(strict_types=1);

use Solver\Year2021\Day10;
use PHPUnit\Framework\TestCase;

class TestHelper extends Day10
{
    public function publicGetscore(string $char)
    {
        return $this->getScore($char);
    }

    public function publicRowIsCorrupted(string $row)
    {
        return $this->rowIsCorrupted($row);
    }

    public function publicGenerateMissingString(string $row)
    {
        return $this->generateMissingString($row);
    }

    public function publicScoreChunk(string $row)
    {
        return $this->scoreChunk($row);
    }
    
}

final class Day10Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day10.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper($parser->getData());

        $this->assertEquals('26397', $solver->getResult(1));
        $this->assertEquals('288957', $solver->getResult(2));
    }

    public function testGetScore()
    {
        $solver     = new TestHelper([]);
        $this->assertEquals(3, $solver->publicGetscore(')'));
        $this->assertEquals(25137, $solver->publicGetscore('>'));
        $this->assertEquals(0, $solver->publicGetscore('a'));
    }
    
    public function testRowIsCorrupted()
    {
        $solver     = new TestHelper([]);
        
        $this->assertEquals('}', $solver->publicRowIsCorrupted('{([(<{}[<>[]}>{[]{[(<()>'));
        $this->assertEquals('>', $solver->publicRowIsCorrupted('<{([([[(<>()){}]>(<<{{'));
        $this->assertEquals(false, $solver->publicRowIsCorrupted('[({(<(())[]>[[{[]{<()<>>'));
    }

    public function testGenerateMissingString()
    {
        $solver     = new TestHelper([]);
        
        $this->assertEquals('}}]])})]', $solver->publicGenerateMissingString('[({(<(())[]>[[{[]{<()<>>'));
        $this->assertEquals(')}>]})', $solver->publicGenerateMissingString('[(()[<>])]({[<{<<[]>>('));
        $this->assertEquals('])}>', $solver->publicGenerateMissingString('<{([{{}}[<[[[<>{}]]]>[]]'));
    }


    public function testScoreChunk()
    {
        $solver     = new TestHelper([]);
        
        $this->assertEquals(288957, $solver->publicScoreChunk('}}]])})]'));
        $this->assertEquals(5566, $solver->publicScoreChunk(')}>]})'));
        $this->assertEquals(294, $solver->publicScoreChunk('])}>'));
    }
}