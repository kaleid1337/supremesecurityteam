<?php

  set_time_limit(3600);

  $l = file('ctcode.txt');

  function add($codeCtry) { //

    $apikey = '9927b48742e657358e2a6ac1f1e529017736c';

    $email = 'supremeservicecode@gmail.com';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/:zone_identifier/settings/security_level");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"mode\":\"challenge\",\"configuration\":{\"target\":\"country\",\"value\":\"{$codeCtry}\"},\"notes\":\"BY API\"}");

    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();

    $headers[] = "X-Auth-Email: {$email}";

    $headers[] = "X-Auth-Key: {$apikey}";

    $headers[] = "Content-Type: application/json";

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {

        echo 'Error:' . curl_error($ch);

    }

    curl_close ($ch);

    return $result;

  }

  $i = 0;

  //run with code country

  foreach($l AS $c){

    $r = add(trim($c));

    $i++;

  }

  echo 'DONE ' . $i;

?>