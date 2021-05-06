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
		
		$p1 = md5(json_encode($body));
		$p2 = date('Y-m-d H:i:s');
		$RawSignature = 'POST\n'.$p1.'\napplication/json\n'.$p2.'\n/v1/test-new-employee';
		$Signature	  = $this->get_signature($SignatureKey, $RawSignature);
		$Authorization	= 'Basic '.base64_encode("$Username:$Password");;			
		return  $Master->setEndpoint($url)
						->setHeaders([
							'Accept' => 'application/json',
							'Content-Type' => 'application/json',
							'API-KEY' => $apiKey,
							'Signature' => $Signature,
							'Signature-Time' => intval(microtime(true)*1000),
							'Authorization' => $Authorization,
						])
						->setBody($body)
						->post();
	}
}
