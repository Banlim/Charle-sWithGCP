<?php
require_once('/home/ubuntu/vendor/autoload.php');
use Firebase\JWT\JWT;
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$fp = fopen("./access_token.json","w");
$fp_k = fopen("./KKK/charls-2019-ServiceKey.json","r");
$fp_k_contents = json_decode(fread($fp_k,filesize("./KKK/charls-2019-ServiceKey.json")));
$private_key = $fp_k_contents->private_key;
$headers = array (
        'alg' => "RS256",
        'typ' => "JWT"
);



$iss="charles-service1@charls-2019.iam.gserviceaccount.com";
$scope="https://www.googleapis.com/auth/cloud-platform";
$scope2 = "https://www.googleapis.com/auth/userinfo.email";
$aud="https://www.googleapis.com/oauth2/v4/token";
$iat=time();
$notBefore = $iat;
$exp = $notBefore + 3600;

$claims = array(
        "iss" => $iss,
        "scope" => $scope,
        "aud" => $aud,
        "exp" => $exp,
        "iat" => $iat
);






$json_h=json_encode($headers);
$json_c=json_encode($claims);
$h64 = base64url_encode($json_h);
$c64 = base64url_encode($json_c);

$hc=$h64.".".$c64;


$key = $private_key;


$jwtSig=null;

$is_ok = openssl_sign(
    $hc,
    $jwtSig,
    $key,
    "sha256WithRSAEncryption"
);


if(!$is_ok){
echo "openssl_sign 오류";
}


$jwtSign = base64url_encode($jwtSig);
$jwt = $hc.".".$jwtSign;
$req = "grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=".$jwt;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $aud);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response =  curl_exec($ch);

curl_close($ch);

fwrite($fp, $response);
fclose($fp);


?>
