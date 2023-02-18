<?php




if (!function_exists('send_ware_SMS')) {
  /**
   * @param $txt
   * @param $phone
   * @return bool|string
   */
  function send_ware_SMS($txt, $phone)
  {
    $active_sms = get_setting('active_sms');

    if ($active_sms == 'mim_sms') {
      return mim_sms($txt, $phone);
    }

    // $csms_id = uniqid();
    // return singleSms($phone, $txt, $csms_id);
    // return mdl_sms($txt, $phone);
  }
}



if (!function_exists('singleSms')) {
  function singleSms($msisdn, $messageBody, $csmsId)
  {
    $API_TOKEN = config('app.ISMS_API_TOKEN'); //put ssl provided api_token here
    $SID = config('app.ISMS_SID'); // put ssl provided sid here
    $DOMAIN = "https://smsplus.sslwireless.com";

    $params = [
      "api_token" => $API_TOKEN,
      "sid" => $SID,
      "msisdn" => $msisdn,
      "sms" => $messageBody,
      "csms_id" => $csmsId
    ];
    $url = trim($DOMAIN, '/') . "/api/v3/send-sms";
    $params = json_encode($params);

    return callApi($url, $params);
    // dd($params);
  }
}




if (!function_exists('callApi')) {
  function callApi($url, $params)
  {
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($params),
      'accept:application/json'
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
}

if (!function_exists('mim_sms')) {
  function mim_sms($txt, $phone)
  {
    try {
      $url = "https://bulksms.teletalk.com.bd/link_sms_send.php";
      $data = [
        "op" => "SMS",
        "user" => get_setting('mim_sms_username'),
        "pass" => get_setting('mim_sms_password'),
        "mobile" => $phone,
        "charset" => "UTF-8",
        "sms" => $txt,
      ];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }
}

if (!function_exists('mdl_sms')) {
  function mdl_sms($msg, $contacts)
  {
    try {
      $url = "http://premium.mdlsms.com/smsapi";
      $data = [
        "api_key" => get_setting('adn_api_key'),
        "type" => "text",
        "contacts" => $contacts,
        "senderid" => get_setting('adn_api_secret'),
        "msg" => $msg,
      ];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      // dd($response);
      return $response;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }
}
