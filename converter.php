<?php
session_start();

require_once "model.php";

class Converter
{
    public $from_currency ;
    public $amount;
    public $to_currency;

    public function __construct()
    {
        $this->from_currency = !empty($_POST['from_currency']) ? $this->data_filtering($_POST['from_currency']) : false;
        $this->amount = !empty($_POST['amount']) ? $this->data_filtering($_POST['amount']) : false;
        $this->to_currency = !empty($_POST['to_currency']) ? $this->data_filtering($_POST['to_currency']) : false;
    }
    
    // the method below for filtering incoming data
    public function data_filtering($incoming_data)
    {
        return htmlentities($incoming_data);
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
    public function exchange_currency()
    {
        $converter = new Converter();
        $current_rate = $this->currency_converter($this->from_currency);
        $current_rate_result = $current_rate * $this->amount * $this->get_to_currency_rate($this->to_currency);
        return $current_rate_result;
    }
}



$converter = new Converter();
$currency_converstion_result = $converter->exchange_currency();



   if (!empty($_POST['submit'])) {
       if (empty($_POST['amount'])) { // error case
           $_SESSION['error'] = "Field Enter Amount was empty, fill it and try again";
           header("Location: http://test.net/CurrencyConverter/index.php");
           exit();
       } else { // successfull case
           
           header("Location: http://test.net/CurrencyConverter/index.php?currency_converstion_result=$currency_converstion_result");
           exit();
              }
   }