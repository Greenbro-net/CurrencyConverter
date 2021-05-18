<?php

class Model
{

    // the method  below calls external api for grabing currency rate
    public function call_currency_api()
    {
         try {
            $access_key = '02d87d6c411fbe784c4053ef4684cbe3';
            // set API Endpoint and API key 
            $endpoint = 'latest';
        
            // Initialize CURL:
            $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $exchangeRates = json_decode($json, true);
          if (empty($exchangeRates)) {
              throw new Exception("Method call_currency_api wasn't successful, check your internet connection");
          } else {
            return $exchangeRates;
                 }
               
             } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                            }
    } 

    // method below gets array from object
    public function get_array(Converter $input_object)
    {   
        try {
          if (empty($input_object)) {
              throw new Exception("Method get_array didn't get a parameter");
          }
            // the function below gets an array from object
            $actual_array = get_object_vars($input_object);
            if (empty($actual_array)) {
                throw new Exception("Method get_array wasn't successful");
            } else {
                return $actual_array;
                   }
            
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }

    // the method below writes history of currency exchanges to history.json
    public function store_currency_exchanges_history(Converter $converter_object)
    {
        try {
          if (empty($converter_object)) {
            throw new Exception("Method store_currency_exchanges_history didn't get parameter");
          }
             // the code below can change object to array for writing
            $array_for_writing = $this->get_array($converter_object);

            $existing_list = $this->grab_currency_exchange_list();
            // the code below appends new exchange operation to the end of existing list of operation
            $existing_list[] = $array_for_writing;
            $json_array = json_encode($existing_list);
            // the code below writes array to json file
            $result_store_currency_exchanges_history = file_put_contents("history.json", $json_array,  LOCK_EX);
            
          if (empty($result_store_currency_exchanges_history)) {
                throw new Exception("Method store_currency_exchanges_history wasn't successful");
          }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    // the method below grabs list of currency exchange from history.json
    public function grab_currency_exchange_list()
    {
         try {
            $list_of_exchanges_array = json_decode(file_get_contents("history.json"), true);
            
            if (empty($list_of_exchanges_array)) {
                throw new Exception("Method grab_currency_exchange_list wasn't successful");
                } else {
                    return $list_of_exchanges_array;
                       }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }


}


       
    