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