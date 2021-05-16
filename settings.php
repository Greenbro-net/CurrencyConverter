<?php
session_start();

require_once 'model.php';

class Settings
{
    // the method below returns currencies
    public function grab_currencies()
    {
        $model = new Model();
        $result = $model->call_currency_api();
        return array_keys($result['rates']);
    }
    // the method below grabs list of currencies from settings.json
    public function grab_currencies_list()
    {
        try {
           $list_of_currencies = json_decode(file_get_contents("settings.json"), true);

           if (empty($list_of_currencies)) {
              throw new Exception("Method grab_currencies_list wasn't successful");
               } else {
                    return $list_of_currencies;
                      }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
    // the method below adds currency to currencies list
    public function add_currency()
    {    
         $existing_currencies_list = $this->grab_currencies_list();

         $currency_for_adding = htmlentities($_POST['add_currency']);
         // the code below appends currency to the end of existing list of currencies
         $existing_currencies_list[] = $currency_for_adding;
         $json_array = json_encode($existing_currencies_list);
         // the code below writes array to json file
         $result_of_add_currency = file_put_contents("settings.json", $json_array,  LOCK_EX);
         if (empty($result_of_add_currency)) { // error case
             return false;
          } else { // success case
             return true;
                 } 
    }
    // the method below deletes currency from currencies list
    public function delete_currency()
    {
        $existing_currencies_list = $this->grab_currencies_list();

        $currency_for_deleting = htmlentities($_POST['delete_currency']);
        // the code below deletes the currency from the existing list of currencies
        foreach ($existing_currencies_list as $currency_key => $existing_currency) {
            if ($existing_currency == $currency_for_deleting) {
                unset($existing_currency);
                // unset($currency_key);
            }
            if (!empty($existing_currency)) {
                $new_existing_currencies_list[] = $existing_currency;
            }
            

        }
        $existing_currencies_list = array_filter($new_existing_currencies_list);

        $json_array = json_encode($existing_currencies_list);
        $result_of_delete_currency = file_put_contents("settings.json", $json_array,  LOCK_EX);
         if (empty($result_of_delete_currency)) { // error case
             return false;
          } else { // success case
             return true;
                 }

    }
    // the method below handling request for currencies list
    public function currency_handler()
    {
        try {
          if (empty($_POST['delete_currency']) && empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You should choose currency if you want add or delete it";
            header("Location: http://test.net/CurrencyConverter/index.php");
            exit();
          }
          // the code below if user choses both option delete and add
          elseif (!empty($_POST['delete_currency']) && !empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You can't choose both variant: add and delete";
            header("Location: http://test.net/CurrencyConverter/index.php");
            exit();
          }
            
            // the block of code below for adding new currency
            if (!empty($_POST['add_currency'])) {
                 $result_of_add_currency = $this->add_currency();
                 if (empty($result_of_add_currency)) { // error case
                     throw new Exception("Method add_currency returns false, there is error");
                 } else { // success case
                    header("Location: http://test.net/CurrencyConverter/index.php");
                    exit();
                        }
            } 
            // the block of code below for deletion currency
            if (!empty($_POST['delete_currency'])) {
                 $result_of_delete_currency = $this->delete_currency();
                 if (empty($result_of_delete_currency)) { // error case
                     throw new Exception("Method delete_currency returns false, there is error");
                 } else { // success case
                    header("Location: http://test.net/CurrencyConverter/index.php");
                    exit();
                        }
            }
                 
               } catch (Exception $exception) {
                    file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              }
    }  
}

if (!empty($_POST['submit'])) {
    $settings_object = new Settings();
    $settings_object->currency_handler();
}