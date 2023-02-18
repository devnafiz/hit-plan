<?php


if(!function_exists('ekPay')){
    function ekPay($data){
        //dd($data);
        try {
            $url = 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/merchant-api/';
            $method = 'POST';
           
           //dd(date('Y-m-d H:i:s \G\M\T+6'));
           //dd(date('Y-m-d H:i:s \G\M\T+6', strtotime('+6 hours')));
            $data2 = [   
                         'mer_info' =>[
                             'mer_reg_id' =>'railway_test',
                             'mer_pas_key' =>'RailBdPay@tSt1'
                          ],
                          'req_timestamp' => date('Y-m-d H:i:s \G\M\T+6', strtotime('+6 hours')),
                          'feed_uri' => [
                             'c_uri' =>'https://www.dev.ekpay.gov.bd/test/cancel',
                             'f_uri' =>'https://www.dev.ekpay.gov.bd/test/fail',
                             's_uri' =>'http://www.marchent.com/success/payment'
                          ],
                         'cust_info' => [
                             'cust_email' =>'nafiz016@gmail.com',
                             'cust_id' =>'12',
                             'cust_mail_addr' =>'dhaka',
                             'cust_mobo_no' =>'+8801795627460',
                             'cust_name' =>'aa'
                          ],
                         'trns_info' =>[
                             'ord_det' =>'order-det',
                             'ord_id' =>'123',
                             'trnx_amt' =>$data['total_fee'],
                             'trnx_currency' =>'BDT',
                             'trnx_id' =>132456
                          ],
                          'ipn_info'=>[
                             'ipn_channel' =>'3',
                             'ipn_email' =>'a@synesisit.com.bd',
                             'ipn_uri' =>'https://www.dev.ekpay.gov.bd/test/ipn'
                           ],
                          'mac_addr' =>'1.1.1.1'
                        
                      ];
          return  callAPI($method,$url,$data2);
            
          } catch (\Throwable $th) {
            //throw $th;
          }

    }

}

if (!function_exists('callAPI')) {
    function callAPI($method, $url, $data2){
        $ch = curl_init();
        //dd($data2);
     // Base settings
    $data_string = json_encode($data2);

   

    //dd($data_string);

    //$ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    $result = curl_exec($ch);
    //dd($result);
   //$response=curl_getinfo($ch); 
   //$array=json_decode($result); 
  // print_r($response);

    if (!empty($result)) {
        $httpsResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         if( $httpsResponseCode ==200){
            $decodedResponse = json_decode($result);

            if($decodedResponse->secure_token){
                $tansId_data=json_decode($data_string);
                $trans_id=$tansId_data->trns_info->trnx_id;
                //dd($trans_id);
                $token =$decodedResponse->secure_token;
                $url="https://sandbox.ekpay.gov.bd/ekpaypg/v1?sToken=$token&trnsID=$trans_id";
                //dd($url);
                //header("Location: $url")
                return $url;
            
            }
         }
    } else {
        echo "error";
    }
   
    curl_close($ch);

    // if (!empty($result)) {
    //     redirect 
    //  } else {
    //      echo "error";
    //  }
  
  
   
 }

 
} 

//payment  search  function
if(!function_exists('search_payment')){
    function search_payment($data){
        //dd($data);
        $detail_data=[

            'trans_date' => $data['trans_date'],
            'trnx_id' =>  $data['trnx_id'],
            'username' => 'railway_test'
        
        ];

        //dd($detail_data);
        return  Search_ipn($detail_data);


    }
}

if(!function_exists('Search_ipn')){

    function Search_ipn($data){
        $url = 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/search-transaction';
        $method = 'POST';
        $data_string = json_encode($data);
        //dd($url);

        $ch = curl_init();
       //dd($data2);
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        //dd($result);
        curl_close($ch);
        return $result;

        // if (!empty($result)) {
    //     redirect 
    //  } else {
    //      echo "error";
    //  }

   
    }
}     
       



  