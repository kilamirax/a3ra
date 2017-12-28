<?php


	$facebook = new Facebook(array(
	  'appId'  => '174175052769874',
	  'secret' => '9d9878df09aab6306618a049b08daadf', status=>true, xfbml=>true
	));
	
	$user = $facebook->getUser();
	
	if ($user) {
	  try {
		$user_profile = $facebook->api('/me');
		$permissions = $facebook->api( '/me/permissions' );
	  } catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	  }
	  
		try {
			$j=0;
			$amigos = $facebook->api('/me/friends');
			foreach ($amigos['data'] as $am)
			{
				//print_r($am);
				$amigo[$j]['id'] = $am['id'];
				$amigo[$j]['name'] = $am['name'];
				$j++;
			}
		} catch (FacebookApiException $e) {
			error_log($e);
		}  
	  
	}


	if ($user) {
	  $logoutUrl = $facebook->getLogoutUrl();
	  $userGeral = $user;
	  
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}
?>