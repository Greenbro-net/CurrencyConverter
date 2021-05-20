<?php

namespace App\Controllers;

use Exception;
use App\Models\Model;

session_start();


class SettingController
{
    protected $model;

    // the method below loads Model to the class
    public function load_model($modelName, $data=[])
    {   
        try { 
            if (file_exists(realpath('../Models/Model.php')))
            {
                require_once realpath('../Models/Model.php');
                // absolute path below 
                return $this->model = new \App\Models\Model;
            } else {
                throw new Exception("Method load_model haven't found a file");
                   }

            } catch (Exception $exception) {
            file_put_contents(realpath("../my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
            'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
       
    }   
    // the method below returns currencies
    public function grab_all_currencies($model)
    {
        try {
            // $model = $this->load_model('Model');s
          if (!$model instanceof Model) {
              throw new Exception("Object of Model didn't instance of Model class");
          }
            $result = $model->call_currency_api();
            $result_grab_currencies = array_keys($result['rates']);
            // $result_grab_currencies = "Fuck You";
          if (empty($result_grab_currencies)) {
            //   throw new Exception("Method grab_currencies wasn't successful");
            } else {
               return $result_grab_currencies;
                   }

            } catch (Exception $exception) {
                    file_put_contents(realpath("../my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           } 
    }
    
    // the method below adds currency to currencies list
    public function add_new_currency()
    {    
      try {  
        $model = $this->load_model('Model');
          require_once '../Models/Model.php';
        $model = new \App\Models\Model;
        if (!$model instanceof Model) {
            throw new Exception("Object of Model didn't instance of Model class");
        }
         $existing_currencies_list = $model->grab_currencies_list();

         $currency_for_adding = htmlentities($_POST['add_currency']);
         if (empty($currency_for_adding)) {
             throw new Exception("Method add new currency didn't prepare argument");
         }
         // the code below appends currency to the end of existing list of currencies
         $current_currency_list[] = $currency_for_adding;
         //  the code below calls model method, it writes to settings.json file
         $result_write_currency_list_to_json = $model->write_currency_list_to_json($current_currency_list);
         return $result_write_currency_list_to_json;
                } catch (Exception $exception) {
                    file_put_contents(realpath("../my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              } 
    }
    // the method bellow handler for add_currency method
    public function add_new_currency_handler()
    {   
        $result_add_new_currency = $this->add_new_currency();
        if (empty($result_add_new_currency)) { // error case
            // throw new Exception("Method add_new_currency returned false, there was error");
        } else { // success case
           header("Location: http://test.net/CurrencyConverter/app/index.php");
           exit();
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
    // the method bellow handler for delete_currency method
    public function delete_currency_handler($result_of_delete_currency)
    {
         if (empty($result_of_delete_currency)) { // error case
                     throw new Exception("Method delete_currency returns false, there is error");
                 } else { // success case
                    header("Location: http://test.net/CurrencyConverter/app/index.php");
                    exit();
                        }
    }


    
    // the method below handling request for currencies list
    public function currency_handler()
    {
        try {
          if (empty($_POST['delete_currency']) && empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You should choose currency if you want add or delete it";
            header("Location: http://test.net/CurrencyConverter/app/index.php");
            exit();
          }
          // the code below if user choses both option delete and add
          elseif (!empty($_POST['delete_currency']) && !empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You can't choose both variant: add and delete";
            header("Location: http://test.net/CurrencyConverter/app/index.php");
            exit();
          }
            
            // the block of code below for adding new currency
            if (!empty($_POST['add_currency'])) {
                //  $result_of_add_currency = $this->add_new_currency();
                 $this->add_new_currency_handler();
            } 
            // the block of code below for deletion currency
            if (!empty($_POST['delete_currency'])) {
                 $result_of_delete_currency = $this->delete_currency();
                $this->delete_currency_handler($result_of_delete_currency);
            }
                 
               } catch (Exception $exception) {
                    file_put_contents(realpath("../my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              }
    }  
    // the method below a wrapper for model method grab_currencies_list
    public function call_grab_currencies_list($model)
    {
        try {  
            // $model = $this->load_model('Model');
            if (!$model instanceof Model) {
                throw new Exception("Object of Model didn't instance of Model class");
            }
             $existing_currencies_list = $model->grab_currencies_list();
    
             $currency_for_adding = htmlentities($_POST['add_currency']);
             // the code below appends currency to the end of existing list of currencies
            //  $existing_currencies_list[] = $currency_for_adding;

            //  the code below for model
            //  $json_array = json_encode($existing_currencies_list);
            //  // the code below writes array to json file
            //  $result_of_add_currency = file_put_contents("settings.json", $json_array,  LOCK_EX);
            //  if (empty($result_of_add_currency)) { // error case
            //      return false;
            //   } else { // success case
            //      return true;
            //          }

            return $existing_currencies_list;
                    } catch (Exception $exception) {
                        file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                        'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                                  }
    }
}



if (!empty($_POST['submit'])) {
    $settings_object = new SettingController();
    $settings_object->currency_handler();
}