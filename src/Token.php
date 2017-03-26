<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 25.03.2017
 * Time: 22:33
 */


namespace IntervalParser;

class Token
{
    const COMMA ='token_comma';
    const DIGIT ='token_digit';
    const BRAKET_OPEN ='token_braket_op';
    const BRAKET_CLOSED ='token_braket_cl';

    public $value;
    public $type;

    /**
     * Token constructor.
     * @param $value
     * @param $type
     */
    public function __construct($type,$value = '')
    {
        $this->value = $value;
        $this->type = $type;
    }
}
