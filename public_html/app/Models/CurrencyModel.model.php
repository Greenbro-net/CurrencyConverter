<?php

namespace App\Models;
use Exception;

class CurrencyModel
{
    // the method below grabs list of currencies from current_currencies_list.json
    public function grab_currencies_list()
    {
        try {
           $list_of_currencies = json_decode(file_get_contents("app/data_store/current_currencies_list.json"), true);

           if (empty($list_of_currencies)) {
              throw new Exception("Method grab_currencies_list wasn't successful");
               } else {
                    return $list_of_currencies;
                      }
            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    // the method below writes data of list of currencies to settings.json
    public function write_currency_list_to_json($current_currency_list)
    {
        $json_array = json_encode($current_currency_list);
         // the code below writes array to json file
         $result_of_add_currency = file_put_contents('app/data_store/current_currencies_list.json', $json_array,  LOCK_EX);
         if (empty($result_of_add_currency)) { // error case
             return false;
          } else { // success case
             return true;
                 }
    }

    // the method below grabs currency rates from storage, it's emitation of external API 
    public function get_currency_rate_from_store()
    {
        try {
          $list_of_currency_rates = json_decode(file_get_contents("app/data_store/currency_rate_store.json"), true);

          if (empty($list_of_currency_rates)) {
              throw new Exception("Method get_currency_rate_from_store wasn't successful");
               } else {
                   return $list_of_currency_rates;
                      } 
            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
}