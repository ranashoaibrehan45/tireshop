<?php
namespace App\Repositories;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

use Log;
use DB;
use Auth;
use Config;
use Carbon\Carbon;

use App\Models\User;

class CommonRepository {
	
	public function setBraintreeConfig()
	{
		\Braintree_Configuration::environment(env('BRAINTREE_ENV'));
		\Braintree_Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
		\Braintree_Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
		\Braintree_Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));
	}

	public function show($obj){
		echo "<pre>"; print_r($obj); echo "</pre>"; die();
	}
	
	/*	get substring after specific part of string	*/
	public function after($startwith, $inthat)
    {
        if (!is_bool(strpos($inthat, $startwith)))
        return substr($inthat, strpos($inthat,$startwith)+strlen($startwith));
    }
		
	/*
	*	Get location geo-coordinates
	*/
	public function getCoordinates($address)
	{
	   	Log::info("getCoordinates: " . $address);
	   	if(trim($address)=='') return array();

	   	// replace all the white space with "+" sign to match with google search pattern
		$address = str_replace(" ", "+", $address); 
		
		$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyDoZ8xgzcJfa4YWJNzcb8mLhnPd3A7x0e4&sensor=false&address=$address";
		
		$response = file_get_contents($url);

		//generate array object from the response from the web
		$json = json_decode($response,TRUE);
		
		if(isset($json['results'][0]))
		{
			$jsonReturn =  array($json['results'][0]['geometry']['location']['lat'], $json['results'][0]['geometry']['location']['lng']);
		}
		else
		{
			$jsonReturn = array();
		}
		
		return $jsonReturn;
   }
   
   	public function encryptId($id)
	{
		return \Crypt::encrypt($id);
	}
	
	public function decryptId($id)
	{
		return \Crypt::decrypt($id);
	}
	
}// end of class