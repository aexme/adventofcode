<?php declare(strict_types=1);

use Solver\Year2021\Day14;
use PHPUnit\Framework\TestCase;

class TestHelper14 extends Day14
{
    public function public_parseData($data)
    {
        return $this->parseData($data);
    }

    public function public_growPolymer($polymer, $rules)
    {
        return $this->growPolymer($polymer, $rules);
    }
    
    public function public_sumHistograms($left, $right)
    {
        return $this->sumHistograms($left, $right);
    }
    
    public function public_splitIntoPairs($polymer)
    {
        return $this->splitIntoPairs($polymer);
    }

    public function public_getHistogramRecursive(string $polymer, array $rules, int $step, int $max_step)
    {
        return $this->getHistogramRecursive($polymer, $rules, $step, $max_step);
    }  
}

final class Day14Test extends TestCase
{
    protected $data_path = __DIR__ .'/data/day14.example';

    public function testGetResult()
    {
        $parser     = new Solver\InputParser($this->data_path);
        $solver     = new TestHelper14($parser->getData());

        $this->assertEquals('1588', $solver->getResult(1));
        $this->assertEquals('2188189693529', $solver->getResult(2));
    }

    public function test_parseData()
    {
        $solver     = new TestHelper14([]);
        $data       = [
                    'NNCB',
                    '',
                    'ON -> S',
                    'SO -> B',
                    'OH -> C',
                    'SN -> F',
                    'BP -> O',
                    'SK -> F',
                    'OO -> K',
        ];
        $res        = $solver->public_parseData($data);

        $this->assertEquals('NNCB', $res[0]);
        $this->assertEquals('S', $res[1]['ON']);
        $this->assertEquals('F', $res[1]['SK']);
    }

    public function test_growPolymer()
    {
        $solver     = new TestHelper14([]);
        
        $polymer    = 'NNCB';
        $rules      = [
            'NN' => 'C',
            'NC' => 'B',
            'CB' => 'H',
        ];
        $res        = $solver->public_growPolymer($polymer, $rules);
        $this->assertEquals('NCNBCHB', $res);
    }

    public function test_getHistogramRecursive()
    {
        $solver     = new TestHelper14([]);
        
        $polymer    = 'NN';

        $rules      = [
            'NN' => 'C',
            'NC' => 'B',
            'CB' => 'H',
            'HB' => 'C',
            'NB' => 'B',
            'BC' => 'B',
            'CN' => 'C',
            'CC' => 'N',

        ];
        $res        = $solver->public_getHistogramRecursive($polymer, $rules, 0, 3);

        $this->assertEquals(2, $res['N']);
        $this->assertEquals(3, $res['B']);
        $this->assertEquals(3, $res['C']);
    }

    public function test_splitIntoPairs()
    {
        $solver     = new TestHelper14([]);

        $polymer    = 'NNCB';
        $res        = $solver->public_splitIntoPairs($polymer);

        $this->assertEquals(['NN', 'NC', 'CB'], $res);
    }

    public function test_public_sumHistograms()
    {
        $solver     = new TestHelper14([]);
        $left       = ['N' => 1, 'C' => 1, 'B' => 1]; 
        $right      = ['N' => 5, 'C' => 0, 'B' => 2];
        $res        = $solver->public_sumHistograms($left, $right);

        $this->assertEquals(['N' => 6, 'C' => 1, 'B' => 3], $res);
    }
}