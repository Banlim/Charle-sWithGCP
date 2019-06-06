<?php

   error_reporting(E_ALL);
   ini_set('display_errors',1);
   include('dbcon.php');

   $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

   if( (($_SERVER['REQUEST_METHOD'] == 'POST')) || $android )
   {
	echo "Request_method success";
   // 안드로이드 코드의 postParameters 변수에 적어둔 이름을 가지고 값을 전달 받는다.
	$imageDate=$_POST['imageDate'];
	$imageEncode=$_POST['imageEncode'];
	$imageName=$_POST['imageName'];
	$imageDecode=base64_decode($imageEncode);
	$encodeCount = strlen($imageEncode);
	//echo $imageDecode
	//header("Content-Type: image/jpeg");

	$file = "./upload/".$imageName;
	$makefile = "touch ./upload/".$imageName;
	$output = shell_exec($makefile);
	$success = file_put_contents($file, $imageDecode);
/*
	$imagePath="./upload/".$imageName;
	$fp = fopen("upload/".$imageName, 'wb');
	fwrite($fp, $imageDecode);
	if(fclose($fp)){
		echo "Image Uploaded";
	}
	else{
		echo "Error uploading image";
	}
*/
	
	   if(empty($imageDate)){
		$errMSG = "imageDate empty";
	   }
	   if(empty($imageEncode)){
		$errMSG = "imageEncode empty";
	   }

	   if(!isset($errMSG)) // 모두 입력되었다면,
	   {
		  try{
			   
			   


		   $query = "INSERT into charlesImgTag (dateImg, img, tag) values(:dateImg, :img, :tag)";
		   $stmt = $connection->prepare($query);
			
		   include("yb.php");

		   
		   
		   $stmt->bindParam(':dateImg', $imageDate);
		   $stmt->bindParam(':img', $file);
		   $stmt->bindParam(':tag', $tag);


		   if($stmt->execute())
		   {
			$successMSG = "새로운 사용자 추가";
		   }
		   else
		   {
			$errMSG = "사용자 추가 에러";
		   }
		}
		catch(PDOException $e){
			die("Database error: ".$e->getMessage());
		}
		echo "imageName is ".$imageName."encodeCount : ".$encodeCount."<br/>";
		echo $imageEncode;
	   }
   }
?> 
