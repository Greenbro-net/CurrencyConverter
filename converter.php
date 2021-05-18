<?php
session_start();

require_once "model.php";

class Converter
{
    public $from_currency ;
    public $amount;
    public $to_currency;
    public $date_of_exchange;
    public $current_rate_result;

    public function __construct()
    {
        $this->from_currency = !empty($_POST['from_currency']) ? $this->data_filtering($_POST['from_currency']) : false;
        $this->amount = !empty($_POST['amount']) ? $this->data_filtering($_POST['amount']) : false;
        $this->to_currency = !empty($_POST['to_currency']) ? $this->data_filtering($_POST['to_currency']) : false;
        $this->date_of_exchange = !empty($this->set_current_data_of_operation()) ? $this->set_current_data_of_operation() : false;
        // the code below prepares retriving of current_rate_result property
        $current_rate = $this->currency_converter($this->from_currency);
        $this->current_rate_result = !empty($this->get_current_rate_result($current_rate)) ?  strval(round($this->get_current_rate_result($current_rate), 2)) : false;
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
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }

    }
    // the method below gets to_currency rate
    public function get_to_currency_rate($to_currency)
    {
        $model = new Model();
        $result = $model->call_currency_api();
        $to_currency_rate = $result['rates'][$to_currency];
        return $to_currency_rate;
    }
    // the method below returns currency rate
    public function currency_converter($from_currency)
    {
        $model = new Model();
        $result = $model->call_currency_api();
        $current_rate = $result['rates'][$from_currency];
        return 1/$current_rate; // there are we find rate of currency by of 1 EUR
    }
    
    // the method below counts amount of money with currency rate
    public function exchange_currency(Converter $converter_object) 
    {
        try {
            $model = new Model();
            // the code below writes data to history.json file
            $model->store_currency_exchanges_history($converter_object);
    
            $current_rate_result = $this->current_rate_result;
            if (empty($current_rate_result)) {
                  throw new Exception("Method exchange_currency wasn't successful");
               } else {
                  return $current_rate_result;
                      }
            
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
}




   if (!empty($_POST['submit'])) {
       if (empty($_POST['amount'])) { // error case
           $_SESSION['error'] = "Field Enter Amount was empty, fill it and try again";
           header("Location: http://test.net/CurrencyConverter/index.php");
           exit();
          } else { // successfull case
           $converter_object = new Converter();
           $currency_converstion_result = $converter_object->exchange_currency($converter_object);

           header("Location: http://test.net/CurrencyConverter/index.php?currency_converstion_result=$currency_converstion_result");
           exit();
              }
   }