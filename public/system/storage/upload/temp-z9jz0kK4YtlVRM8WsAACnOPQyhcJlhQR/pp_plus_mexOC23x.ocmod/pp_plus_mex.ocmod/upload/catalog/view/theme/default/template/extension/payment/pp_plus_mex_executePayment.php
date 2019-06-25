<?php
/*
Payment Method PayPalPlus México by Treebes
Author: Juan Lanzagorta FV
www.treebes.com
Ver 1.0 
15 November 2017

Code is distributed as is.
It is not permited to re-distribute this code.

Support only available for buyers in our database,
via email soporte@treebes.com and having available
support hours in the included support contract.

NOTES:
+ Only available for Mexican Pesos (MXN)
+ Only available for Mexican Credit Cards
+ Only one status of payment is managed (no cancelation, no refund, no resend, no re-authorise, etc.)

Treebes nor the Authors ARE NOT responsible for the use or consecuences of the use of this code.
*/

global $access_token;
$access_token= $_REQUEST['access_token'];
$paypalMode = $_REQUEST['paypalMode'];
$payerId = $_REQUEST['payerId'];
$paymentID = $_REQUEST['paymentID'];

	if ($paypalMode=="sandbox") {
    	$host = 'https://api.sandbox.paypal.com';
	}
	if ($paypalMode=="live") {
   		$host = 'https://api.paypal.com';
	}
#GET ACCESS TOKEN
$url = $host.'/v1/payments/payment/'.$paymentID.'/execute/'; 
$execute = '{"payer_id" : "'.$payerId.'"}';
$json_resp = make_post_call($url, $execute);
$json_resp = stripslashes(json_format($json_resp));

echo $json_resp;

function json_format($json) {
  if (!is_string($json)) {
    if (phpversion() && phpversion() >= 5.4) {
      return json_encode($json, JSON_PRETTY_PRINT);
    }
    $json = json_encode($json);
  }
  $result      = '';
  $pos         = 0;
  $strLen      = strlen($json);
  $indentStr   = "\t";
  $newLine     = "\n";
  $prevChar    = '';
  $outOfQuotes = true;
  for ($i = 0; $i < $strLen; $i++) {
    $copyLen = strcspn($json, $outOfQuotes ? " \t\r\n\",:[{}]" : "\\\"", $i);
    if ($copyLen >= 1) {
      $copyStr = substr($json, $i, $copyLen);
      $prevChar = '';
      $result .= $copyStr;
      $i += $copyLen - 1;
      continue;
    }
		$char = substr($json, $i, 1);
    
    if (!$outOfQuotes && $prevChar === '\\') {
      $result .= $char;
      $prevChar = '';
      continue;
    }
    if ($char === '"' && $prevChar !== '\\') {
      $outOfQuotes = !$outOfQuotes;
    }else if ($outOfQuotes && ($char === '}' || $char === ']')) {
      $result .= $newLine;
      $pos--;
      for ($j = 0; $j < $pos; $j++) {
        $result .= $indentStr;
      }
    }else if ($outOfQuotes && false !== strpos(" \t\r\n", $char)) {
      continue;
    }
    $result .= $char;
    if ($outOfQuotes && $char === ':') {
      $result .= ' ';
    }else if ($outOfQuotes && ($char === ',' || $char === '{' || $char === '[')) {
      $result .= $newLine;
      if ($char === '{' || $char === '[') {
        $pos++;
      }
      for ($j = 0; $j < $pos; $j++) {
        $result .= $indentStr;
      }
    }
    $prevChar = $char;
  }
  return $result;
}

function make_post_call($url, $postdata) {
	global $access_token;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST,'TLSv1');
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
							'Authorization: Bearer '.$access_token,
							'Accept: application/json',
							'Content-Type: application/json'
							));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
	$response = curl_exec( $curl );
	if (empty($response)) {
	    die(curl_error($curl));
	    curl_close($curl);
	} else {
	    $info = curl_getinfo($curl);
	    curl_close($curl);
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo $response;
			die();
	    }
	}
	$jsonResponse = json_decode($response, TRUE);
	return $jsonResponse;
}

?>
