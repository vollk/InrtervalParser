<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 25.03.2017
 * Time: 22:43
 */

use IntervalParser\Tokenizer;
use IntervalParser\Token;

class TokenizerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Tokenizer
     */
    private $tokenizer;

    public function setUp()
    {
        parent::setUp();
        $this->tokenizer = new Tokenizer();
    }

    /**
     * @dataProvider tokensProvider
     */
    public function testTokens($input, $expected)
    {
        $this->assertTrue($expected === $this->getArray($input));
    }

    public function tokensProvider()
    {
        return [
            ['1,2,3',['1', Token::COMMA, '2', Token::COMMA , '3']],
            ['',[]],
            ['1',['1']],
            [',',[Token::COMMA]],
            ['33',['33']],
            ['[1,2]',[Token::BRAKET_OPEN,'1',Token::COMMA,'2',Token::BRAKET_CLOSED]]
        ];
    }

    /**
     * @dataProvider incorrectProvider
     * @expectedException OutOfRangeException
     */
    public function testIncorrectChar($input)
    {
        $this->getArray($input);
    }

    public function incorrectProvider()
    {
        return [
            ['d'],
            ['2[,],d'],
        ];
    }

    private function getArray($string)
    {
        $res = [];
        foreach ($this->tokenizer->stream($string) as $token)
        {
            if($token->type === Token::DIGIT)
                $res[] = $token->value;
            else
                $res[] = $token->type;
        }
        return $res;
    }
}