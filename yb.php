<!DOCTYPE>
<html>
<body>
<?php 
include("yb2.php");
#aud = "https://automl.googleapis.com/v1beta1/projects/charls-2019/locations/us-central1/models/ICN466343393655797462:predict";
$aud = "https://automl.googleapis.com/v1beta1/projects/charls-2019/locations/us-central1/models/ICN5017704104406782599:predict";
/*
$img_f = fopen("img_enc.json", "r");
$img = fread($img_f, filesize("img_enc.json"));
 */

#$img = $imageEncode;
#
$fp = fopen($file, 'r');
$image = fread($fp, filesize($file));
fclose($fp);

$img = base64_encode($image);


$jsobj 	= array (
        'payload' =>
        array(
                'image' =>
                array (
                'imageBytes' => $img )
        )
);


$token_f = fopen("access_token.json","r");
$token = json_decode(fread($token_f, filesize("access_token.json")))->access_token;
$token = trim($token);
$header = array(
	'Content-Type: application/json',
	'Authorization: Bearer '.$token,
);


$req = json_encode($jsobj);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $aud);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);


#$result = json_decode(curl_exec($ch));

$result = curl_exec($ch);
print_r($result);

$result = json_decode($result);
print_r($result);


print_r($result);

$tag = ($result->payload)[0]->displayName;
curl_close($ch);


?>



</body>
</html>
