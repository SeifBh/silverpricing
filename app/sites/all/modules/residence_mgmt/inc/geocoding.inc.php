<?php

require_once __DIR__ . "/../vendor/autoload.php";

function geocoding($address) {

    $apiConfig = json_decode(file_get_contents(__DIR__ . "/../config.json"));

    $url = "https://us1.locationiq.com/v1/search.php?key=$apiConfig->token&q=$address&format=json&limit=1";

    $curl = curl_init($url);

    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER    =>  true,
      CURLOPT_FOLLOWLOCATION    =>  true,
      CURLOPT_MAXREDIRS         =>  10,
      CURLOPT_TIMEOUT           =>  30,
      CURLOPT_CUSTOMREQUEST     =>  'GET',
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      //echo 'cURL Error #:' . $err;
      return null;
    } else {
      return json_decode($response);
    }
}

function reverseGeocoding($latitude, $longitude) {

    $apiConfig = json_decode(file_get_contents(__DIR__ . "/../config.json"));

    $url = "https://us1.locationiq.com/v1/reverse.php?key=$apiConfig->token&lat=$latitude&lon=$longitude&format=json";

    $curl = curl_init($url);

    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER    =>  true,
      CURLOPT_FOLLOWLOCATION    =>  true,
      CURLOPT_MAXREDIRS         =>  10,
      CURLOPT_TIMEOUT           =>  30,
      CURLOPT_CUSTOMREQUEST     =>  'GET',
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      //echo 'cURL Error #:' . $err;
      return null;
    } else {
      return json_decode($response);
    }
}

