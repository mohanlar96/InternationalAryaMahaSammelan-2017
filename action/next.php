<?php
require "../db/config.php";
require "../db/database.php";
$db=new Database($config);
$page=$_POST['current'];



    include "../phpqrcode/qrlib.php";

$nextIndex=($page)*10;

$dataSend[0]=$page+1;
$dataSend[1]= $nextIndex;

$data=$db->selectStar("register");

function displayCard($pic,$name,$id,$nrc,$address,$country,$phNo,$qr){
	$card="";
	if($pic==="default.png"){
		$pic="photo/default.png";
		$card="smartcard2.gif";
	}else{
		$card="smartcard.gif";
	}
	echo "

	<div class='card' style=\"background: url('img/$card') ;
	background-repeat: no-repeat;
	background-size: 100% 100%;\">
	<div class='group' style='display: block;float: left;'>
		<div>
			<img class='profile' src='$pic'>
			<span class='name'>$name</span>
			<span class='id'> $id </span>
			
		</div>
		<ul class='info'  >
			<li>$nrc</li>
			<li>$address</li>
			<li>$country</li>
			<li>$phNo</li>
		</ul>
	</div>
	<div  >
		<img  class='qrCode' src='$qr'>
	</div>
	
</div>
";
}


$string="";
for ($i=$nextIndex; $i<$nextIndex+10; $i++){
	if(sizeof($data)<$i+1){
		break;
	}$pic="default.png";
		

			$id=$data[$i]["ID"];
			if(isset(glob("../photo/$id.*")[0])){				
				$pic= glob("../photo/$id.*")[0];
				$pic=explode("../", $pic)[1];
				
			}
			 QRcode::png($id, "../QRCode/$id.png", "L", "3", 2);
			$name=$data[$i]["Name"];
			$nrc=$data[$i]["NRC"];
			$region=trim($data[$i]["City"])." Region";
			$country=$data[$i]["Country"];
			$ph=$data[$i]["Phone"];
			$qr="QRCode/$id.png";

	$string.= displayCard($pic,$name,$id,$nrc,$region,$country,$ph,$qr);

		}
	$dataSend[2]=$string;

echo $string;

















?>