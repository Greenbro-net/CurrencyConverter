<?php

namespace App\Controllers;

use App\Core\Controller;
use Exception;

class ConverterController extends Controller
{
    public $from_currency ;
    public $amount;
    public $to_currency;
    public $date_of_exchange;
    public $current_rate_result;
 

    public function __construct() 
    {
        if (!empty($_POST['from_currency']) && !empty($_POST['to_currency']) && !empty($_POST['amount'])) {
            // set properties only if call is from form
            $this->from_currency = !empty($_POST['from_currency']) ? $this->data_filtering($_POST['from_currency']) : false;
            $this->amount = !empty($_POST['amount']) ? $this->data_filtering($_POST['amount']) : false;
            $this->to_currency = !empty($_POST['to_currency']) ? $this->data_filtering($_POST['to_currency']) : false;
            $this->date_of_exchange = !empty($this->set_current_data_of_operation()) ? $this->set_current_data_of_operation() : false;
            // the code below prepares retriving of current_rate_result property
            $current_rate = $this->currency_converter($this->from_currency);
            $this->current_rate_result = !empty($this->get_current_rate_result($current_rate)) ?  strval(round($this->get_current_rate_result($current_rate), 2)) : false;
        }
        
    }

    // the method below renders page
    public function show_exchange_operations()
    {
        $this->model('ConverterModel');
        $this->view('converter' . DIRECTORY_SEPARATOR . 'index');
        $this->view_page_title = 'List of previous exchange operations';
        $this->view->render();
    }

    
    // the method below sets data of currency change operation
    public function set_current_data_of_operation()
    {
        date_default_timezone_set("Europe/Kiev");
        return date("Y-m-d H:i:s");
    }
    // the method below for filtering incoming data
    public function data_filtering($incoming_data)
    {
        return htmlentities($incoming_data);
    }
    
    // the method below gets property of current_rate_result
    public function get_current_rate_result($current_rate)
    {
        try {
            if (empty($current_rate)) {
                throw new Exception("Method get_current_rate_result doesn't get parameter");
               }

            $result_get_current_rate_result = $current_rate * $this->amount * $this->get_to_currency_rate($this->to_currency);

            if (empty($result_get_current_rate_result)) {
                throw new Exception("Method get_current_rate_result wasn't successful");
                } else {
                    return $result_get_current_rate_result;
                       }

            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }

    }
    // the method below gets to_currency rate
    public function get_to_currency_rate($to_currency)
    {
        if (!empty($to_currency)) {
            $currency_model_obj = $this->load_model('CurrencyModel');
            $result = $currency_model_obj->get_currency_rate_from_store();
            $to_currency_rate = $result[$to_currency];
            return $to_currency_rate;
        }
        
    }
    // the method below returns currency rate
    public function currency_converter($from_currency)
    {
        try {
          if (empty($from_currency)) { // error case
            throw new Exception("Method currency_converter didn't get a parameter");
          }
            $currency_model_obj = $this->load_model('CurrencyModel');
            $result = $currency_model_obj->get_currency_rate_from_store();
            $current_rate = $result[$from_currency];

            $result_currency_converter = 1 / $current_rate; // there are we find rate of currency by of 1 EUR
            
            if (empty($result_currency_converter)) {
                throw new Exception("Method currency_converter wasn't successful");
             } else {  // success case
                 return $result_currency_converter;
                    } 

            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
    
    

    // the method below grabs all entries from storage_exchange_operation.json
    public function call_grab_currency_exchange_list()
    {
        try {
          $converter_model_obj = $this->load_model('ConverterModel');
          // the code below checks in right model or not
          if (!$converter_model_obj instanceof \App\Models\ConverterModel) {
              throw new Exception("Current object didn't instance of ConverterModel class");
          }
            $result_call_grab_currency_exchange_list = $converter_model_obj->grab_currency_exchange_list();
          if (empty($result_call_grab_currency_exchange_list)) {
              throw new Exception("Method call_grab_currency_exchange_list wasn't successful");
          } else {
              return $result_call_grab_currency_exchange_list;
                 }
            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              }
    }

    
    // the method below counts amount of money with currency rate
    public function exchange_currency(ConverterController $converter_controller_object) 
    {
        try {
            $converter_model_obj = $this->load_model('ConverterModel');
            // the code below writes data to storage_exchange_operation.json file
            $converter_model_obj->store_currency_exchanges_history($converter_controller_object);
    
            $current_rate_result = $this->current_rate_result;
            if (empty($current_rate_result)) {
                  throw new Exception("Method exchange_currency wasn't successful");
               } else {
                  return $current_rate_result;
                      }
            
            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
    // the method below is handler for exchange_currency method
    public function preparing_call_exchange_currency()
    {
        try { 
          if (!empty($_POST['submit'])) {
            if (empty($_POST['amount'])) { // error case
                $_SESSION['error'] = "Field Enter Amount was empty, fill it and try again";
                header("Location: http://currency_converter.com");
                exit();
                } else { // successfull case
                    $converter_controller_obj = new ConverterController();
                    // the code checks is the object instance of current class
                    if (!$converter_controller_obj instanceof ConverterController) {
                        throw new Exception("Current object didn't instance of ConverterController class");
                    }
                    $currency_converstion_result = $this->exchange_currency($converter_controller_obj);
                    header("Location: http://currency_converter.com/?currency_converstion_result=$currency_converstion_result");
                    exit();
                       }
          }

            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }


}



   