<?php
session_start();

require_once 'model.php';

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

<form align="center" action="converter.php" method="post">

<div id="box">
<h2><center>Calculator</center></h2>
<table>
    <div id="result_block">
    <?php display_currency_converstion_result(); ?>
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
	 <option value="UAH" selected>Ukrainian Hryvnia(UAH)</option>
	 <option value="USD">US Dollar(USD)</option>
     <option value="EUR">European Union(EUR)</option>
	 </select>
</td>
</tr>
<tr>
	<td>
	<br><center>To:<select name='to_currency'>
	 <option value="USD" selected >US Dollar(USD)</option>
	 <option value="JPY">Japanese Yen(JPY)</option>
	 <option value="EUR">European Union(EUR)</option>
	
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

    // now the function below should return 5 last entries
    function display_list_of_exchanges($number)
    {   
        $model = new Model();
        $list_currency_exchanges = $model->grab_currency_exchange_list();
        echo "<pre>";
        if (empty($number)) { // display all entries which we have
            // the code below displays list of previous exchanges
            foreach($list_currency_exchanges as $list_currency_exchange) {
                echo "<p class=\"entries\"> For exchange: " .  $list_currency_exchange['from_currency']  . "</p>";
                echo "<p class=\"entries\"> What currency we need: " . $list_currency_exchange['to_currency'] . "</p>";
                echo "<p class=\"entries\"> Amount of money we have for exchange: " . $list_currency_exchange['amount'] . "</p>";
                echo "<p class=\"entries\"> Amount of money we will get: " . $list_currency_exchange['current_rate_result']. "</p>";
                echo "<p class=\"entries\"> Time of operation: " . $list_currency_exchange['date_of_exchange']. "</p>";
                echo "<br>";
            }
        } else {
            // the code below gets how many arrays are
            $number_of_arrays = count($list_currency_exchanges);
            $start_from = $number_of_arrays - $number;
            foreach($list_currency_exchanges as $key_number =>$list_currency_exchange) {
                        
                        if ($key_number < $start_from) {
                            continue;
                        } else {
                            echo "<p class=\"entries\"> For exchange: " .  $list_currency_exchange['from_currency']  . "</p>";
                            echo "<p class=\"entries\"> What currency we need: " . $list_currency_exchange['to_currency'] . "</p>";
                            echo "<p class=\"entries\"> Amount of money we have for exchange: " . $list_currency_exchange['amount'] . "</p>";
                            echo "<p class=\"entries\"> Amount of money we will get: " . $list_currency_exchange['current_rate_result']. "</p>";
                            echo "<p class=\"entries\"> Time of operation: " . $list_currency_exchange['date_of_exchange']. "</p>";
                            echo "<br>";
                               }
                        }
               }
    }

    // the function below handling how many entries will display
    function list_handler() 
    {   
        if (empty($_GET['number_of_entries'])) {
            $number_of_entries = 0;
        } else {
            $number_of_entries = htmlentities($_GET['number_of_entries']);
               }
        display_list_of_exchanges($number_of_entries);              
    }

    if (!empty($_POST['SubmitListHandler']) && !empty($_GET['number_of_entries'])) {
        header("Location: http://test.net/CurrencyConverter/index.php?number_of_entries=$number_of_entries");
        exit();
    }

    list_handler();
    
?>

<h2>Settings</h2>
<form action="index.php" method="GET">
<label for="lname">How many etries you would like to see:</label><br>
<input type="text" id="number_of_entries" name="number_of_entries">
<input type='submit' name='submit' value="SubmitListHandler"></center>
</form>

</body>
</html>




