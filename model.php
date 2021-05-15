<?php

class Model
{

    public function call_currency_api()
    {
        $endpoint = 'convert';
        $access_key = '02d87d6c411fbe784c4053ef4684cbe3';

        // set API Endpoint and API key 
        $endpoint = 'latest';
        // $access_key = 'API_KEY';

        // Initialize CURL:
        $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        // Access the exchange rate values, e.g. GBP:
        echo $exchangeRates['rates']['USD'];


        // testing code below 
        // $ch = 'http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'';  
        echo "<pre>"; 
        var_dump($exchangeRates);    
    }


}