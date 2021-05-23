<?php


class CurrencyController extends Controller
{
    // the method below returns all currencies
    public function grab_all_currencies()
    {
        try {
            $converter_model_obj = $this->load_model('CurrencyModel');
            $result = $converter_model_obj->get_currency_rate_from_store();
            $result_grab_currencies = array_keys($result);
          if (empty($result_grab_currencies)) {
              throw new Exception("Method grab_currencies wasn't successful");
            } else {
               return $result_grab_currencies;
                   }

            } catch (Exception $exception) {
                    file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           } 
    }
    
    // the method below adds currency to currencies list
    public function add_new_currency()
    {    
      try {  
        $currency_model_obj = $this->load_model('CurrencyModel');
        
        if (!$currency_model_obj instanceof CurrencyModel) {
            throw new Exception("Current object didn't instance of CurrencyModel class");
        }
         $current_currency_list = $currency_model_obj->grab_currencies_list();

         $currency_for_adding = htmlentities($_POST['add_currency']);
         if (empty($currency_for_adding)) {
             throw new Exception("Method add new currency didn't prepare argument");
         }
         // the code below appends currency to the end of existing list of currencies
         $current_currency_list[] = $currency_for_adding;
         
         $result_write_currency_list_to_json = $currency_model_obj->write_currency_list_to_json($current_currency_list);
         
         return $result_write_currency_list_to_json;
                } catch (Exception $exception) {
                    file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              } 
    }
    // the method bellow handler for add_currency method
    public function handler_add_new_currency()
    {   
        $result_add_new_currency = $this->add_new_currency();
        if (empty($result_add_new_currency)) { // error case
            throw new Exception("Method add_new_currency returned false, there was error");
        } else { // success case
           header("Location: http://currency_converter.com");
           exit();
               }
    }


    // the method below deletes currency from currencies list
    public function delete_currency()
    {
        try {
            $currency_model_obj = $this->load_model("CurrencyModel");

            if (!$currency_model_obj instanceof CurrencyModel) {
                throw new Exception("Current object didn't instance of CurrencyModel class");
            }
            $existing_currencies_list = $currency_model_obj->grab_currencies_list();

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
    
            $result_deletion_write_currency_list_to_json = $currency_model_obj->write_currency_list_to_json($existing_currencies_list);

            return $result_deletion_write_currency_list_to_json;

            } catch (Exception $exception) {
                file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           } 
    }
    // the method bellow handler for delete_currency method
    public function handler_delete_currency($result_of_delete_currency)
    {
         if (empty($result_of_delete_currency)) { // error case
                     throw new Exception("Method delete_currency returns false, there is error");
                 } else { // success case
                    header("Location: http://currency_converter.com");
                    exit();
                        }
    }

    // the method below handling request for currencies list
    public function currency_handler()
    {
        try {
          if (empty($_POST['delete_currency']) && empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You should choose currency if you want add or delete it";
            header("Location: http://currency_converter.com");
            exit();
          }
          // the code below if user choses both option delete and add
          elseif (!empty($_POST['delete_currency']) && !empty($_POST['add_currency'])) {
            $_SESSION['error'] = "You can't choose both variant: add and delete";
            header("Location: http://currency_converter.com");
            exit();
          }
            
            // the block of code below for adding new currency
            if (!empty($_POST['add_currency'])) {
                //  $result_of_add_currency = $this->add_new_currency();
                 $this->handler_add_new_currency();
            } 
            // the block of code below for deletion currency
            if (!empty($_POST['delete_currency'])) {
                 $result_of_delete_currency = $this->delete_currency();
                $this->handler_delete_currency($result_of_delete_currency);
            }
                 
               } catch (Exception $exception) {
                    file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                    'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                              }
    }  


    // the method below a wrapper for model method grab_currencies_list
    public function call_grab_currencies_list()
    {
        try {  
            $currency_model_obj = $this->load_model('CurrencyModel');
            // the code below checks in right model or not
            if (!$currency_model_obj instanceof CurrencyModel) {
                throw new Exception("Object of CurrencyModel didn't instance of CurrencyModel class");
            }
             $existing_currencies_list = $currency_model_obj->grab_currencies_list();
    

            return $existing_currencies_list;
                    } catch (Exception $exception) {
                        file_put_contents(realpath("my-errors.log"), 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                        'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                                  }
    }
}


