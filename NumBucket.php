<?php

class NumBucket
{
    public $min;
    public $max;
    public $total;
    public $numbers=array();
    public function __construct($min, $max, $total){
        $this->min = $min;
        $this->max = $max;
        $this->total = $total;
    }

    public function addNumber($number){
        $this->numbers[] = $number;
    }
}