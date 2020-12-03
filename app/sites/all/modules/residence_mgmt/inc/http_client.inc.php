<?php

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