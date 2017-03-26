<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 26.03.2017
 * Time: 23:10
 */

use IntervalParser\IntervalParser;

class IntervalParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var IntervalParser
     */
    private $parser;

    public function setUp()
    {
        parent::setUp();
        $this->parser = new IntervalParser();
    }

    /**
     * @dataProvider IntervalsProvider
     */
    public function testIntervals($input, $expected)
    {
        $this->assertTrue($expected === $this->getArray($input));
    }

    public function IntervalsProvider()
    {
        return [
            ['',[]],
            ['1', [
                ['1', '1']
            ]],
            ['[1,2]', [
                ['1', '2']
            ]],
            ['1,[1,2]', [
                ['1', '1'],
                ['1', '2']
            ]],
            ['[1,2],1', [
                ['1', '2'],
                ['1', '1']
            ]],
            ['1,2', [
                ['1', '1'],
                ['2', '2']
            ]],
            ['[1,2],[3,4]', [
                ['1', '2'],
                ['3', '4']
            ]],
        ];
    }

    private function getArray($input)
    {
        $res = [];
        foreach ($this->parser->parse($input) as $interval) {
            $interval_ar = [$interval->from, $interval->to];
            $res[] = $interval_ar;
        }
        return $res;
    }
}