<?php
function sms($mnumber,$msg)
{
//Your authentication key
$query="SELECT * FROM defaults where type='SMSAPIKEY' and status='0'";
$pagesData=fetchData($query);
$apikey="";
if(is_array($pagesData) || is_object($pagesData))
{
foreach($pagesData as $pageData)
{
	$apikey =$pageData['defaultVal'];
}
}
$authKey = $apikey;
//Multiple mobiles numbers separated by comma
$mobileNumber = $mnumber;
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "SHLIFE";
//Your message to send, Add URL encoding here.
$message = urlencode($msg);
//Define route 
$route = "4";
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);
//API URL
$url="http://control.smsdekho.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
if(curl_errno($ch))
{
    echo 'error:' . curl_error($ch);
}

curl_close($ch);

return $output;
}
?>