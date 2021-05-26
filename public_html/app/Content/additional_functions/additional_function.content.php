<?php

// the function below displays error
function display_error()
{
    if (!empty($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
}
// the function below displays result of currency conversion
function display_currency_converstion_result()
{
    if (!empty($_GET['currency_converstion_result'])) {
        echo "You will get : " . $_GET['currency_converstion_result'] . " with current rate";
    }
}

// function below displays history of currency exchange
function display_exchange_operation($list_currency_exchange)
{
    echo "<p class=\"entries\"> For exchange: " .  $list_currency_exchange['from_currency']  . "</p>";
    echo "<p class=\"entries\"> What currency we need: " . $list_currency_exchange['to_currency'] . "</p>";
    echo "<p class=\"entries\"> Amount of money we have for exchange: " . $list_currency_exchange['amount'] . "</p>";
    echo "<p class=\"entries\"> Amount of money we will get: " . $list_currency_exchange['current_rate_result']. "</p>";
    echo "<p class=\"entries\"> Time of operation: " . $list_currency_exchange['date_of_exchange']. "</p>";
    echo "<br>";
}


// function below displays list of all currencies, call method from CurrencyController
function display_all_currencies()
{   
    try {
    
        $currency_controller_obj = new App\Controllers\CurrencyController();
    
        if (!$currency_controller_obj instanceof \App\Controllers\CurrencyController) {
            throw new Exception("Current object didn't instanceof CurrencyController");
        }
        $list_of_currencies = $currency_controller_obj->grab_all_currencies();

        if (empty($list_of_currencies)) {
            throw new Exception("Function display_all_currencies wasn't succsessful");
        }
    
            foreach ($list_of_currencies as $currency) {
            echo "<option value=\"$currency\" >$currency</option>";
            }
        } catch (Exception $exception) {
            file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
            'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                       }
    
    
}
// the function below displays list of currencies which were added to settings.json
function display_added_currencies()
{
    $currency_controller_obj = new App\Controllers\CurrencyController();

    $list_of_added_currencies = $currency_controller_obj->call_grab_currencies_list();

    foreach ($list_of_added_currencies as $currency) {
        echo "<option value=\"$currency\" >$currency</option>";
    }
}

// the function below handling how many entries of exchange will display
function handler_quantity_exchange_list() 
{   
    if (empty($_GET['number_of_entries'])) {
        $number_of_entries = 0;
    } else {
        $number_of_entries = htmlentities($_GET['number_of_entries']);
           }
    display_list_of_exchanges($number_of_entries);              
}

// now the function below displays numbers of last entries
function display_list_of_exchanges($number)
{   
    
    $converter_controller_obj = new App\Controllers\ConverterController();
    $list_currency_exchanges = $converter_controller_obj->call_grab_currency_exchange_list();
    echo "<pre>";
    if (empty($number)) { // display all entries which we have
        // the code below displays list of previous exchanges
        foreach($list_currency_exchanges as $list_currency_exchange) {
            display_exchange_operation($list_currency_exchange);
        }
    } else { // display current number of entries
        // the code below gets how many arrays are
        $number_of_arrays = count($list_currency_exchanges);
        $start_from = $number_of_arrays - $number;
        foreach($list_currency_exchanges as $key_number =>$list_currency_exchange) {
                    if ($key_number < $start_from) {
                        continue;
                    } else {
                        display_exchange_operation($list_currency_exchange);
                           }
                    }
           }
}





?>







