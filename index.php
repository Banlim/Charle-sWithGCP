<!DOCTYPE html>
<html>
<head>
	<meta charshet = "utf-8">
	<title>charle project</title>
	<style>
		html{
			box-sizing: border-box;
			border: 10px solid #A9CCE3;
		}
		body{
			background: #D5F5E3;
		}

		.container{
			padding: 10px 0px 10px 0px;
			border-bottom: 10px dashed #A9CCE3;
		}

		.date_view{
			font-size: xx-large;
			font-weight: bolder;
			color: #45B39D;
		}
		.gallery{
			display: grid;
			grid-template-columns: repeat(auto-fit, 33%);
			grid-auto-rows: minmax(180px, auto);
		}

		.gallery_item{
			margin: 5px;
		}
		.gallery_img{
			width: 100%;
			height: 100%;
			margin: 0px;
			object-fit: cover;
			display: block;
		}

		.tag_view{
			font-weight: bolder;
			color: #45B39D;
			font-size: large;
		}
	</style>
</head>
<body>

<?php

try{
	$connection = new PDO('mysql:host=localhost;dbname=charlesDB;charset=utf8', 'charles', 'charles2019');
	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	echo $e->getMessage();
}

$query = "SELECT seq, dateImg, img, tag FROM charlesImgTag ORDER BY dateImg";
$stmt = $connection->prepare($query);
$stmt->execute();

$stmt->setFetchMode(PDO::FETCH_BOTH);

$cnt = 0;
$leastDate = null;
$nowDate = null;
echo '<div class = "container">';

while($row = $stmt->fetch()){
	if($cnt == 0){ // 모든 데이터의 첫 날짜로 설정
		$leastDate = $row[1];
		$nowDate = $row[1];
		echo '<div class = "date_view">'.$row[1].'</div>';
		echo '<div class = "gallery">';
	}
	$nowDate = $row[1];
	if($leastDate != $nowDate){
		$leastDate = $nowDate;
		echo '</div></div><div class = "container">';
		echo '<div class = "date_view">'.$row[1].'</div>';
		echo '<div class = "gallery">';
	}

	echo '<div class = "gallery_item"><div>';

	$pathImg = (string)$row[2];
	
	echo '<img src="./'.$row[2].'" class = "gallery_img" alt = "Image">';
	$tag = (string)$row[3];
	echo '<p class = "tag_view"> #'.$tag.'</p></div></div>';

	$cnt += 1;


}

echo '</div></div>';
// connection close
$connection = null;


?>
</body>
</html>



