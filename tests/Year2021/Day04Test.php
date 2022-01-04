<?php declare(strict_types=1);

use Solver\Year2021\Day04;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day04Helper extends Day04
{
    public function publicGetNumbers()
    {
        return $this->getNumbers();
    }

    public function publicGetBoards()
    {
        return $this->getBoards();
    }

    public function publicBoardHasNumber(array $board, int $number)
    {
        return $this->boardHasNumber($board, $number);
    }

    public function publicBoardHasWon(array $board)
    {
        return $this->boardHasWon($board);
    }

    public function publicGetSumFromBoard(array $board)
    {
        return $this->getSumFromBoard($board);
    }

    public function publicRemoveCollumnFromBoard(array $board, int $collumn)
    {
        return $this->removeCollumnFromBoard($board, $collumn);
    }
    
}

final class Day04Test extends TestCase
{
    public function testGetResult()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $this->assertEquals('4512', $solver->getResult(1));
        $this->assertEquals('1924', $solver->getResult(2));
    }

    public function testGetNumbers()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $numbers    = $solver->publicGetNumbers();

        $this->assertIsArray($numbers);
        $this->assertEquals(4, $numbers[1]);
        $this->assertEquals(1, $numbers[26]);
    }

    public function testGetboards()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $boards     = $solver->publicGetBoards();

        $this->assertIsArray($boards);
        $this->assertCount(3, $boards);

        $this->assertEquals(22, $boards[0][0][0]);
        $this->assertEquals(19, $boards[0][4][4]);

        $this->assertEquals(15, $boards[1][0][1]);
        $this->assertEquals(12, $boards[1][4][3]);

        $this->assertEquals(14, $boards[2][0][0]);
        $this->assertEquals(7, $boards[2][4][4]);
    }

    public function testBoardHasNumber()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $data       = [
            ['0','1','2','3','4'],
            ['10','11','12','13','14'],
            ['20','21','22','23','24'],
            ['30','31','32','33','34'],
            ['40','41','42','43','44']
        ];

        $result = $solver->publicBoardHasNumber($data, 11);

        $this->assertIsArray($result);
        $this->assertEquals(1, $result[0]);
        $this->assertEquals(1, $result[1]);

        $result = $solver->publicBoardHasNumber($data, 34);

        $this->assertIsArray($result);
        $this->assertEquals(4, $result[0]);
        $this->assertEquals(3, $result[1]);

        $result = $solver->publicBoardHasNumber($data, 35);
        $this->assertEquals(false, $result);
    }


    public function testBoardHasWon()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $data       = [
            'rows' => [0,1,2,1,5],
            'collumns' => [0,0,1,2,1],
        ];

        $result = $solver->publicBoardHasWon($data);
        $this->assertEquals(4, $result[0]);

        $data       = [
            'rows' => [0,1,2,1,2],
            'collumns' => [0,2,5,2,1],
        ];

        $result = $solver->publicBoardHasWon($data, 35);
        $this->assertEquals(2, $result[1]);

        $data       = [
            'rows' => [0,1,2,1,2],
            'collumns' => [0,1,1,2,1],
        ];

        $result = $solver->publicBoardHasWon($data, 35);
        $this->assertEquals(false, $result);
    }

    public function testGetSumFromBoard()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $data       = [
            ['0','1','2','3','4'],
            ['10','10','10','10','10'],
            ['2','2','2','2','2'],
            'rows' => [0,1,2,1,2],
            'collumns' => [0,1,1,2,1],
        ];

        $result = $solver->publicGetSumFromBoard($data);

        $this->assertEquals(70, $result);
    }

    public function testRemoveCollumnFromBoard()
    {
        $parser     = new Solver\InputParser(__DIR__ .'/data/day04.example');
        $solver     = new Day04Helper($parser->getData());

        $data       = [
            ['0','1','2','3','4'],
            ['10','10','10','10','10'],
            ['2','2','2','2','2'],
            'rows' => [0,1,2,1,2],
            'collumns' => [0,1,1,2,1],
        ];

        $result = $solver->publicRemoveCollumnFromBoard($data, 2);

        $this->assertEquals(3, $result[0][3]);
        $this->assertCount(4, $result[1]);
        $this->assertCount(5, $result['rows']);
        $this->assertCount(5, $result['collumns']);
    }
}