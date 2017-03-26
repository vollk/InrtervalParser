<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 25.03.2017
 * Time: 22:23
 */

namespace IntervalParser;

class Tokenizer
{
    /**
     * @param $string
     * @return Token[]
     */
    public function stream($string)
    {
        $digit = '';
        $token = null;

        for($i =  0; $i < strlen($string);$i++)
        {
            $char = $string[$i];
            $token = null;
            switch($char)
            {
                case ',':
                    $token = new Token(Token::COMMA);
                    break;
                case '[':
                    $token = new Token(Token::BRAKET_OPEN);
                    break;
                case ']':
                    $token = new Token(Token::BRAKET_CLOSED);
                    break;
                default:
                {
                    if(!is_numeric($char))
                        throw new \OutOfRangeException('invalid char '.$char);
                    $digit.=$char;
                    break;
                }
            }

            if($token && (strlen($digit) > 0))
            {
                yield new Token(Token::DIGIT, $digit);
                $digit = '';
            }

            if($token)
                yield $token;
        }
        //last digit
        if($digit)
            yield new Token(Token::DIGIT, $digit);


    }
}