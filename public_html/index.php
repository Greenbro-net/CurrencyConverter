<?php


echo "Hello World";
// TO DO FRONT CONTROLLER, VIEW LAYER AND CREATE ROUTING WITH CONTROLLER NAME AND METHOD NAME

// die;
use App\Models\Model;
use App\Controllers\SettingController;
use App\Controllers\ConverterController;


require_once realpath('vendor/autoload.php');
require_once '../config.php';

// reedit the code below 
require_once 'app/functions_storage.php';



// the function below checkout does methods and controllers exist or not
function checkout_url()
{ 
    $url = Application::clearupParameter();
    // folder where we store our classes 
    $file_controller_names = array_slice(scandir('app/controller/'), 2);

    // the code below gets controller name and store it in array  
    foreach($file_controller_names as $controller_key => $file_controller_name ) {
    // the code below deletes empty arrays from array 
        
        // the code below for gets name with Controller part 
        $file_controller_array = explode('.', $file_controller_name);
        // the arrays below have names of controllers  
        $controller_names[$controller_key] = $file_controller_array[0];

        // the code below for gets name without Controller part 
        $file_controller_array = explode('Controller', $file_controller_name);
        $short_controller_names[$controller_key] = $file_controller_array[0];
    }

    // the function below gets methods name and create array with class methods
    foreach($controller_names as $controller_name) {
         
        $arrays_method_names[] = get_class_methods($controller_name);
    }
    // the function below create makes one simple array and delete three methods 
    foreach($arrays_method_names as $method_names) {
        
            foreach($method_names as $key_method_name => $method_name) {
                
                if (($method_name == 'view') || ($method_name == 'model') || ($method_name == '__construct')) {
                    unset($method_names[$key_method_name]);
                } else {
                    $controller_methods[] = $method_name; 
                       }   
                } 
            }

    // the code below for case of pure domain name greenbro.net
    if (empty($url[0]) && empty($url[1])) {
    Application::call_by_url();
     return $variable = TRUE;
    }
    // the code below for case only one of two url parameters
    elseif(empty($url[0]) || empty($url[1])) {
     $variable = FALSE;
    }

    elseif (!empty($url[0]) && !empty($url[1])) {
      foreach ($short_controller_names as $controller_name_check) {
        if ($controller_name_check == $url[0]) {
            foreach ($controller_methods as $controller_method_check)
            {
               if ($controller_method_check == $url[1]) {
                //    the code below calls method of actual controller 
                   Application::call_by_url();
                   return $variable = TRUE;
               } 
            }
        }  else { // the else block escapes undefined variable notice beloц
            $variable = FALSE;
                }
            } 
        }
    // if page does not exists you will be located in 404.php
    if ($variable !== TRUE) {
        $page_404 = new troubleController();
        $page_404->page_404();
    }

}



// The code below autoload functions for each classes 
function autoload($className)
{
    $modules = [ROOT,APP,CORE,CONTROLLER,DATA,TRAITS];

    foreach ($modules as $current_dir)
    {
        $path = $current_dir . $className . ".controller.php";
        if (file_exists($path))
        {
            require_once $path;
            return;
        }
        // the code below for trait
        $path = $current_dir . $className . ".trait.php";
        if (file_exists($path))
        {
            require_once $path;
            return;
        } else {
            $path = $current_dir . $className . ".data.php";
            if(file_exists($path)) {
                require_once $path;
                return;
            }
        }
    }
}
spl_autoload_register('autoload', false);

// Application is call in checkout_url function above
checkout_url();



?>

































<?php

die;

// function below displays list of all currencies
function display_all_currencies()
{   
    try {
        $model = new Model;
        $object_setting_controller = new SettingController();
        // var_dump($object_setting_controller instanceof SettingController);
        if (!$object_setting_controller instanceof SettingController) {
            throw new Exception("Object of setting_controller wasn't instanceof SettingController");
        }
        $list_of_currencies = $object_setting_controller->grab_all_currencies($model);
        // unset($list_of_currencies);

        if (empty($list_of_currencies)) {
            // throw new Exception("Function display_all_currencies wasn't succsessful");
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
    $settings = new SettingController();
    $model = new Model();
    $list_of_added_currencies = $settings->call_grab_currencies_list($model);

    foreach ($list_of_added_currencies as $currency) {
        echo "<option value=\"$currency\" >$currency</option>";
    }
}


?>



<html>
<head>
<style>
#error_block {
    color: red;

}
#result_block {
    color: green;
    font-size: 35px;
}
.entries {
    display: inline;
    font-size: 15px;
}
</style>
<title>Currency converter</title>
</head>

<body>

<form align="center" action="Controllers/ConverterController.php" method="post">

<div id="box">
<h2><center>Calculator</center></h2>
<table>
    <div id="result_block">
    <?php 
       display_currency_converstion_result(); 
       ?>
    </div>
	<tr>
   
	<td>
    <div id="error_block">
    <?php display_error(); ?>
    </div>
		Enter Amount:<input type="text" name="amount"><br>
	</td>
</tr>
<tr>
<td>
	<br><center>From:<select name='from_currency'>
      <?php 
         display_added_currencies(); 
         ?>
	 </select>
</td>
</tr>
<tr>
	<td>
	<br><center>To:<select name='to_currency'>
     <?php 
        display_added_currencies(); 
         ?>
	
	</select>
</td>
</tr>
<tr>
<td><center><br>
<input type='submit' name='submit' value="ConvertNow"></center>
</td>
</tr>
</table>
</form>



<h2>History</h2>
<?php 

    // now the function below displays numbers of last entries
    function display_list_of_exchanges($number)
    {   
        
        $model = new Model();
        $list_currency_exchanges = $model->grab_currency_exchange_list();
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

    // the function below handling how many entries will display
    function list_quantity_handler() 
    {   
        if (empty($_GET['number_of_entries'])) {
            $number_of_entries = 0;
        } else {
            $number_of_entries = htmlentities($_GET['number_of_entries']);
               }
        display_list_of_exchanges($number_of_entries);              
    }

    // the code below handling how many entries displays on the page
    if (!empty($_POST['SubmitListHandler']) && !empty($_GET['number_of_entries'])) {
        header("Location: http://test.net/CurrencyConverter/app/index.php?number_of_entries=$number_of_entries");
        exit();
    }

    // die;
    list_quantity_handler();
    // die;
?>

<h2>Settings</h2>
  <h4>To form list of currency operations</h4>
<form action="index.php" method="GET">
<label for="lname">How many etries you would like to see:</label><br>
<input type="text" id="number_of_entries" name="number_of_entries">
<input type='submit' name='submit' value="SubmitListHandler"></center>
</form>


<!-- the code below for adding  currencies to settings.json  -->
<h4>To form list of currencies for exchanging</h4>
<form action="Controllers/SettingController.php" method="POST">
<label for="lname">What currency you would like to add:</label><br>
    <td><br><center>From:<select name='add_currency'>
    <option value="" selected>Choose currency for adding</option>
        <?php
           display_all_currencies();
        ?> 
    </select></td>
<!-- the code below for deletes currency from the settings.jsons -->
<label for="lname">What currency you would like to delete:</label><br>
    <td><br><center>From:<select name='delete_currency'>
    <option value="" selected>Choose currency for deleting</option>
        <?php
        //    display_added_currencies()
        ?> 
    </select></td>

<input type='submit' name='submit' value="SubmitCurrencyList"></center>
</form>

</body>
</html>




