<?php 


class CurrencyModelTest extends PHPUnit\Framework\TestCase
{

    public function  test_grab_currency_exchange_list()
    {
        $currency_model_obj = new \App\Models\CurrencyModel;
        $array_result = $currency_model_obj->grab_currencies_list();
        $this->assertIsArray($array_result);
    }

    public function test_get_currency_rate_from_store()
    {
        $currency_model_obj = new \App\Models\CurrencyModel;
        $array_result = $currency_model_obj->get_currency_rate_from_store();
        $this->assertIsArray($array_result);    
    }



}

?> 