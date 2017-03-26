<?php
/**
 * Created by PhpStorm.
 * User: vollk_2
 * Date: 26.03.2017
 * Time: 23:04
 */

namespace IntervalParser;

class Interval
{
    public $from;
    public $to;

    /**
     * Interval constructor.
     * @param $from
     * @param null $to
     */
    public function __construct($from,$to = null)
    {
        $this->from = $from;
        if(is_null($to))
            $this->to = $from;
        else
            $this->to = $to;
    }
}