<?php

#try{
#	$connection = new PDO('mysql:host=localhost;dbname=charlesDB;charset=utf8', 'charles', 'charles2019');
#	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
#	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
#	echo "데이터 베이스 연결 성공 !!<br/>";
#}
#catch(PDOException $e){
#	echo $e->getMessage();
#}

#$query = "SELECT seq, dateImg, img, tag FROM charlesImgTag";

#$tag = '';

#$query = "SELECT seq, dateImg, img, tag from charlesImgTag where seq=10";

#$stmt = $connection->prepare($query);
#$stmt->execute();

#$stmt->setFetchMode(PDO::FETCH_BOTH);

#while($row = $stmt->fetch()){
#    echo $row[0].'|';
#    echo $row[1].'|';
#    echo $row[2].'|';
#    echo $row[3].'<br/>';

echo $file;
$fp = fopen($file, 'r');
$image = fread($fp, filesize($file));
fclose($fp);
	
    include("yb.php");

#    echo $tag;
#    if($row[3] == ''){
#	    echo "이프문";
#	    $query_update = 'UPDATE charlesImgTag set tag="'.$tag.'" where seq=10';

#	    echo $query_update;
#	    $stm = $connection->prepare($query_update);
#	    $stm->execute();
#	    echo "확ㅇ니";
#	    $stmt = $connection->prepare($query);
#	    $stmt->execute();
#	    break;
#    }


    ######################################################################
 #   $src = 'data: '.mime_content_type($image).';base64,'.$image_data;
 #   $decoded_img = base64_decode($image);
 #   echo '<img src="'.$src.'">';
    ########################################################################
 #   $seq = (string)$row[0];

#    $file = './image'.$seq.'.jpg';
#    $makefile = "touch ./image".$seq.".jpg";

#    $output = shell_exec($makefile);
#    echo $output;


    


  #  echo '<img src="'.$file.'" class = "gallery_img" alt = "Image">';
    


// connection close


?>
