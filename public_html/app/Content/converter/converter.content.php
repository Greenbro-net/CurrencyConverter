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

<form align="center" action="http://currency_converter.com/converter/preparing_call_exchange_currency" method="post">

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

    handler_quantity_exchange_list();

    // the code below handling how many entries displays on the page
  if (!empty($_POST['SubmitListHandler']) && !empty($_GET['number_of_entries'])) {
    header("Location: http://currency_converter.com?number_of_entries=$number_of_entries");
    exit();
}
?>

<h2>Settings</h2>
  <h4>To form list of currency operations</h4>
<form action="http://currency_converter.com" method="GET">
<label for="lname">How many etries you would like to see:</label><br>
<input type="text" id="number_of_entries" name="number_of_entries">
<input type='submit' name='submit' value="SubmitListHandler"></center>
</form>


<!-- the code below for adding  currencies to settings.json  -->
<h4>To form list of currencies for exchanging</h4>
<form action="http://currency_converter.com/currency/currency_handler" method="POST">
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
           display_added_currencies();
        ?> 
    </select></td>

<input type='submit' name='submit' value="SubmitCurrencyList"></center>
</form>

</body>
</html>




