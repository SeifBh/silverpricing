<?php

require_once __DIR__ . "/../vendor/autoload.php";


// DEBUG VARIABLE
function varDebug( $variable ) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}

// HTTP GET REQUEST
function getRequest( $uri ) {

    if( $uri === null || $uri === "" ) { return null; }

    $client = new GuzzleHttp\Client([ 'verify' => false ]);
    $result = $client->request('GET', $uri, []);

    //echo "status code : " . $result->getStatusCode() . "\n";

    if( $result->getStatusCode() == "200" ) {
        return $result->getBody();
    }

    return null;

}

// HTTP POST REQUEST
function postRequest( $uri, $postData ) {

  if( $uri === null || $uri === "" ) { return null; }

  $client = new GuzzleHttp\Client(['verify' => false ]);
  $result = $client->request('POST', $uri, [ 'json' => $postData ]);

  //echo "status code : " . $result->getStatusCode() . "\n";

  if( $result->getStatusCode() == "200" ) {
      return $result->getBody();
  }

  return null;

}

function postCurlRequest($url, $postData) {

  if( $url === null || $url === "" ) { return null; }

  $ch = curl_init($url);

  $payload = json_encode($postData);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  curl_close($ch);

  return $result;
}
