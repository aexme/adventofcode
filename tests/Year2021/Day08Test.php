<?php declare(strict_types=1);

use Solver\Year2021\Day08;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertContains;

class Day08Helper extends Day08
{
    public function publicParseRow(string $row)
    {
        return $this->parseRow($row);
    }

    public function publicGenerateMap (array $input)
    {
        return $this->generateMap($input);
    }
}

final class Day08Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day08.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new Day08Helper($parser->getData());

        $this->assertEquals('26', $solver->getResult(1));
        $this->assertEquals('61229', $solver->getResult(2));
    }

    public function testParseRow()
    {
        $solver     = new Day08Helper([]);
        [$input, $output]     = $solver->publicParseRow('gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce');

        $this->assertIsArray($input);
        $this->assertIsArray($output);
        $this->assertEquals('gcafb', $input[0]);
        $this->assertEquals('fgae', $output[0]);
    }
    
    public function testGenerateMap()
    {
        $solver             = new Day08Helper([]);
        $row                = 'acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab | cdfeb fcadb cdfeb cdbaf';
        [$input, $output]   = $solver->publicParseRow($row);
        $map                = $solver->publicGenerateMap($input);

        $this->assertIsArray($map);
        
        $this->assertEquals('d', $map[0]);
        $this->assertEquals('e', $map[1]);
        $this->assertEquals('a', $map[2]);
        $this->assertEquals('f', $map[3]);
        $this->assertEquals('g', $map[4]);
        $this->assertEquals('b', $map[5]);
        $this->assertEquals('c', $map[6]);
    }
    
}