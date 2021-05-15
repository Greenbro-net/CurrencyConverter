<?php
session_start();

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
</style>
<title>Currency converter</title>
</head>

<body>

<form align="center" action="converter.php" method="post">

<div id="box">
<h2><center>Currency Converter</center></h2>
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






<h1>Currency converter</h1>

<h2>Calculator<h2>
<h2>History</h2>
<h2>Settings</h2>

</body>
</html>




