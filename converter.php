<?php

class Converter
{
    public $from_currency;
    public $amount;
    public $to_currency;

    public function converter($from_currency)
    {
        return 1/$from_currency;
    }
}