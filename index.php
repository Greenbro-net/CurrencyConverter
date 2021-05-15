



<html>
<head>
<title>Currency converter</title>
</head>

<body>
<h1>Currency converter</h1>

<h2>Calculator<h2>
<h2>History</h2>
<h2>Settings</h2>

<form align="center" action="currencyconvertor.php" method="post">

<div id="box">
<h2><center>Currency Converter</center></h2>
<table>
	<tr>
	<td>
		Enter Amount:<input type="text" name="amount"><br>
	</td>
</tr>
<tr>
<td>
	<br><center>From:<select name='cur1'>
	 <option value="UAH" selected>Ukrainian Hryvnia(UAH)</option>
	 <option value="USD">US Dollar(USD)</option>
     <option value="EUR">European Union(EUR)</option>
	 </select>
</td>
</tr>
<tr>
	<td>
	<br><center>To:<select name='cur2'>
	 <option value="USD" selected >US Dollar(USD)</option>
	 <option value="JPY">Japanese Yen(JPY)</option>
	 <option value="EUR">European Union(EUR)</option>
	
	</select>
</td>
</tr>
<tr>
<td><center><br>
<input type='submit' name='submit' value="CovertNow"></center>
</td>
</tr>
</table>
</form>

</body>
</html>




