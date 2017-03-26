<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 26.03.2017
 * Time: 23:00
 */

namespace IntervalParser;

class IntervalParser
{
    const PARSER_STATE_BEGIN = 'st_begin';
    const PARSER_STATE_AFTER_BOUNDS_SEPARATOR = 'st_b_sep';
    const PARSER_STATE_AFTER_OPEN_INTERVAL = 'st_open_int';
    const PARSER_STATE_AFTER_CLOSE_INTERVAL = 'st_close_int';
    const PARSER_STATE_AFTER_FIRST_DIGIT = 'st_fs_digit';
    const PARSER_STATE_AFTER_SECOND_DIGIT = 'st_sec_digit';
    const PARSER_STATE_AFTER_ONCE_DIGIT = 'st_once_digit';

    /**
     * @param $string
     * @return Interval[]
     */
    public function parse($string)
    {
        $state = self::PARSER_STATE_BEGIN;
        $token_from = null;
        $tokenizer = new Tokenizer();

        foreach($tokenizer->stream($string) as $token)
        {
            //echo 'token '. $token->type.' '.$token->value.'<br>';
            switch($state)
            {
                case self::PARSER_STATE_BEGIN:
                {
                    switch($token->type)
                    {
                        case Token::BRAKET_OPEN;
                            $state = self::PARSER_STATE_AFTER_OPEN_INTERVAL;
                            break;
                        case Token::DIGIT;
                            yield new Interval($token->value);
                            $state = self::PARSER_STATE_AFTER_ONCE_DIGIT;
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->value);
                    }
                }
                    break;
                case self::PARSER_STATE_AFTER_OPEN_INTERVAL:
                {
                    switch($token->type)
                    {
                        case Token::DIGIT:
                            $token_from = $token;
                            $state = self::PARSER_STATE_AFTER_FIRST_DIGIT;
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->value);
                    }
                    break;
                }
                case self::PARSER_STATE_AFTER_FIRST_DIGIT:
                {
                    switch($token->type)
                    {
                        case Token::COMMA:
                            $state = self::PARSER_STATE_AFTER_BOUNDS_SEPARATOR;
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->value);
                    }
                    break;
                }
                case self::PARSER_STATE_AFTER_BOUNDS_SEPARATOR:
                {
                    switch($token->type)
                    {
                        case Token::DIGIT:
                            $state = self::PARSER_STATE_AFTER_SECOND_DIGIT;
                            yield new Interval($token_from->value, $token->value);
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->value);
                    }
                    break;
                }
                case self::PARSER_STATE_AFTER_SECOND_DIGIT:
                {
                    switch($token->type)
                    {
                        case Token::BRAKET_CLOSED:
                            $state = self::PARSER_STATE_AFTER_CLOSE_INTERVAL;
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->type. ' '.$token->value);
                    }
                    break;
                }
                case self::PARSER_STATE_AFTER_CLOSE_INTERVAL:
                case self::PARSER_STATE_AFTER_ONCE_DIGIT:
                {
                    switch($token->type)
                    {
                        case Token::COMMA:
                            $state = self::PARSER_STATE_BEGIN;
                            break;
                        default:
                            throw new \InvalidArgumentException('invalid token '.$token->value);
                    }
                    break;
                }
                default:
                    throw new \LogicException('invalid state '.$state);
            }
        }
    }
}
