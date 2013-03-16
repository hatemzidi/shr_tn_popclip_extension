<?php

// get the username and the key
$username = getenv('POPCLIP_OPTION_USERNAME');
$userkey  = getenv('POPCLIP_OPTION_KEY');

// what url was copied ?
$url = getenv('POPCLIP_TEXT');

// prepare a calls

	$service  = "http://shr.tn/api/v1/short?long=" + urlencode($url);
	$service += "&format=txt&username=" + $username;
	$service += "&api_key=" + $userkey;

	// execute request
	$ch = curl_init($service);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"User-Agent: popclip.extension/1.0",
		"Content-Type: text/plain",
		 ));
	$response = curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ( $code==200 || $code == 201) {
	echo json_decode($response)->data->short_url;
	exit(0); // success
}  
else if ($code==401) {
	exit(2); // bad auth
}
else {
	exit(1); // other error
}
?>