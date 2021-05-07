<?php

namespace App\Http\Controllers;

use App\Providers\Master;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
		
	function get_signature($key, $str)
	{
		$s = hash_hmac('sha256', $str, $key, true);
		return base64_encode($s);
	}

    public function hit(){
		$Master 		= new Master;
		
		$Username 		= 'linc-test';
		$Password 		= '123456';
		$apiKey 		= 'ojh545we4t5254sdgfsaefstg65478';
		$SignatureKey 	= '879sdg78dsfg56sd4g7987eswg76';
		$body 			= ['email'=>'andilevi@gmail.com'];
		$method			= 'POST';
		$url			= '/v1/test-new-employee';
		$type			= 'application/json';
		
		$timezone = new \DateTimeZone('Asia/Jakarta');
		$date = new \DateTime();
		$date->setTimeZone($timezone);
		
		$currentMilliSecond = (int) (microtime(true) * 1000);
		$ms = $currentMilliSecond.PHP_EOL;
		
		$p1 = md5(json_encode($body));
		// $p2 = $date->format('Y-m-d H:i:s');
		$p2 = date('Y-m-d H:i:s', intval($currentMilliSecond/1000)).PHP_EOL;
		$RawSignature = 'POST\n'.$p1.'\n'.$type.'\n'.$p2.'\n'.$url;
		// $RawSignature = "POST\n$p1\n$type\n$p2\n$url";
		// echo $RawSignature;die;
		$Signature	  = $this->get_signature($SignatureKey, $RawSignature);
		$Authorization	= 'Basic '.base64_encode("$Username:$Password");			
		
		$header = [
							'Authorization' => $Authorization,
							'Accept' => $type,
							'Content-Type' => $type,
							'API-KEY' => $apiKey,
							'Signature' => $Signature,
							'Signature-Time' => $ms,
						];
		return  $Master->setEndpoint($url)
						->setHeaders($header)
						->setBody($body)
						->post();
	}
}
