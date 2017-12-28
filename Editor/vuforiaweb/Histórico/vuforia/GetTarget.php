<?php
ini_set("include_path", '/home/hrasko/php:' . ini_get("include_path") );
require_once 'HTTP/Request2.php';
require_once 'SignatureBuilder.php';

// See the Vuforia Web Services Developer API Specification - https://developer.vuforia.com/resources/dev-guide/retrieving-target-cloud-database
// The GetTarget sample demonstrates how to query a single target by target id.
class GetTarget{
	
	//Server Keys
	private $access_key 	= "d1471f6c8243c0c6384e9f822c3e7e8748eeb91f";
	private $secret_key 	= "a3b02ad8f1a77e2380ed68e1ff14020aba38d3c8";
	
	private $targetId 	= "29457753c8be4768a1f77062b9f6f7b2";
	private $url 		= "https://vws.vuforia.com";
	private $requestPath = "/targets/";// . $targetId;
	private $request;
	
	function GetTarget(){

		$this->requestPath = $this->requestPath . $this->targetId;
		
		$this->execGetTarget();
	}
	
	private function execGetTarget(){
		
		$this->request = new HTTP_Request2();
		$this->request->setMethod( HTTP_Request2::METHOD_GET );
		
		$this->request->setConfig(array(
				'ssl_verify_peer' => false
		));
		
		$this->request->setURL( $this->url . $this->requestPath );
		
		// Define the Date and Authentication headers
		$this->setHeaders();
		
		
		try {
		
			$response = $this->request->send();
		
			if (200 == $response->getStatus()) {
				echo $response->getBody();
			} else {
				echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
						$response->getReasonPhrase(). ' ' . $response->getBody();
			}
		} catch (HTTP_Request2_Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
		
		
	}
	
	private function setHeaders(){
		$sb = 	new SignatureBuilder();
		$date = new DateTime("now", new DateTimeZone("GMT"));

		// Define the Date field using the proper GMT format
		$this->request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT" );
		// Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
		$this->request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $sb->tmsSignature( $this->request , $this->secret_key ));

	}
}

?>