<?php

// create class for testing purpose
class TestClass
{
    public $array = array(1,2,3,4);
}


class ConverterModelTest extends PHPUnit\Framework\TestCase
{

    public function  test_grab_currency_exchange_list()
    {
        $converter_model_obj = new \App\Models\ConverterModel;
        $array_result = $converter_model_obj->grab_currency_exchange_list();
        $this->assertIsArray($array_result);
    }

    public function test_get_array()
    {
        $converter_model_obj = new \App\Models\ConverterModel;
        
        $input_obj = new TestClass();
        $array_result = $converter_model_obj->get_array($input_obj);
        $this->assertIsArray($array_result);    
    }



}
?> 