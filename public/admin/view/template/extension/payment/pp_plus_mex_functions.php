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
if (!isset($_REQUEST['action'])
    || !isset($_REQUEST['clientId'])
    || !isset($_REQUEST['secret'])
    || !isset($_REQUEST['paypalMode'])
    ){
    echo json_encode(array ("error"=>'ACCESS DENIED'));
    exit();
}

global $clientId, $secret, $paypalMode, $access_token;
$action=$_REQUEST['action'];
$clientId=$_REQUEST['clientId'];
$secret=$_REQUEST['secret'];
$paypalMode=$_REQUEST['paypalMode'];

if ($paypalMode!='1' && $paypalMode!='0'){
    echo json_encode(array ("error"=>'ACCESS DENIED'));
    exit();  
}

switch ($action){
  case 'getProfileIds':
    getProfileIds();
    break;
  
  case 'deleteProfileIds':
    deleteProfileIds();
    break;
  
  default:
    echo json_encode(array ("error"=>'ACCESS DENIED'));
    exit();    
    break;
}

function getProfileIds(){
  global $clientId, $secret, $paypalMode,$access_token;
  if ($paypalMode=="1") {
      $host = 'https://api.sandbox.paypal.com';
  }else{
      $host = 'https://api.paypal.com';
  }
  
  $url = $host.'/v1/oauth2/token'; 
  $postArgs = 'grant_type=client_credentials';
  $access_token= get_access_token($url,$postArgs);
  $url = $host.'/v1/payment-experience/web-profiles';

  $json_resp = make_get_call($url);
  if (!count($json_resp)>0){
    createProfileId();
    $url = $host.'/v1/oauth2/token'; 
    $postArgs = 'grant_type=client_credentials';
    $access_token= get_access_token($url,$postArgs);
    $url = $host.'/v1/payment-experience/web-profiles';
    $json_resp = make_get_call($url);
  }
  $json_resp = stripslashes(json_format($json_resp));
  echo $json_resp;
}

function deleteProfileIds(){
  global $clientId, $secret, $paypalMode,$access_token;
  if ($paypalMode=="1") {
      $host = 'https://api.sandbox.paypal.com';
  }else{
      $host = 'https://api.paypal.com';
  }
  
  $url = $host.'/v1/oauth2/token'; 
  $postArgs = 'grant_type=client_credentials';
  $access_token= get_access_token($url,$postArgs);
  
  $xp_profile=$_REQUEST['profile_id'];
  
  $url = $host.'/v1/payment-experience/web-profiles/'.$xp_profile;
  
  $json_resp = delete_xp($url,$access_token);
  $json_resp = stripslashes(json_format($json_resp));
  
  echo $json_resp;
  
}

function createProfileId(){
  global $clientId, $secret, $paypalMode, $access_token;
  # Get form data
  $profileName='Treebes OpenCart PPPlus '.date('Y-m-d-H:i:s');
  $merchantName='Treebes OpenCart PPPlus';
  
  if ($paypalMode=="1") {
      $host = 'https://api.sandbox.paypal.com';
  }else{
      $host = 'https://api.paypal.com';
  }

  $url = $host.'/v1/oauth2/token'; 
  $postArgs = 'grant_type=client_credentials';
  $access_token= get_access_token($url,$postArgs);
  
  $url = $host.'/v1/payment-experience/web-profiles';
  $xpprofile = '
  
  {
      "name": "'.$profileName.'",
      "presentation": {
          "brand_name": "'.$merchantName.'"
      },
      "input_fields": {
          "no_shipping": 1,
          "address_override": 1
      }
  }
  
  ';
  
  $json_resp = make_post_call($url, $xpprofile);

  //return $json_resp;

}

function json_format($json) {
  if (!is_string($json)) {
    if (phpversion() && phpversion() >= 5.4) {
      return json_encode($json, JSON_PRETTY_PRINT);
    }
    $json = json_encode($json);
  }
  $result      = '';
  $pos         = 0;               // indentation level
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

function get_access_token($url, $postdata) {
	global $clientId, $secret;
	$curl = curl_init($url); 
  curl_setopt($curl, CURLOPT_POST, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST,'TLSv1');
	curl_setopt($curl, CURLOPT_USERPWD, $clientId . ":" . $secret);
	curl_setopt($curl, CURLOPT_HEADER, false); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
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
	$jsonResponse = json_decode( $response );
	return $jsonResponse->access_token;
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

function make_get_call($url) {
  global $access_token;
  $curl = curl_init($url); 
  curl_setopt($curl, CURLOPT_POST, false);
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

function delete_xp($url, $access_token) {
    $curl = curl_init($url); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST,'TLSv1');
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '.$access_token,
        'Content-Type: application/json'
        ));
  $response = curl_exec( $curl );
  if (empty($response)) {
      $response = "Success";
      curl_close($curl);
      return $response;
  } else {
      curl_close($curl);
      return $response;
  }
  return $response;
}
?>