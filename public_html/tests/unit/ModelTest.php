<?php

// namespace App\Models;
class ModelTest extends PHPUnit\Framework\TestCase
{
    // public function test_call_currency_api()
    // {
    //     $model = new App\Models\Model;
    //     $object_result = $model->call_currency_api();
    //     $this->assertIsObject($object_result);
    // }

    public function  test_grab_currency_exchange_list()
    {
        $model = new App\Models\Model;
        $array_result = $model->grab_currency_exchange_list();
        $this->assertIsArray($array_result);
    }
    public function test_store_currency_exchanges_history()
    {
        $model = new App\Models\Model;
        $converter_object = new App\Converter();
        $result_store_currency_exchanges_history = $model->store_currency_exchanges_history($converter_object);
    }
}

?> 