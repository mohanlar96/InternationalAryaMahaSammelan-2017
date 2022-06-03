<?php 
session_start();
require "db/config.php";
require "db/database.php";
$db=new Database($config);

 $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
   
    $PNG_WEB_DIR = 'QRCode/';

    include "phpqrcode/qrlib.php";



if($_SESSION["admin"]!="success"){
	header("Location:index.php");
	}

$info=@$_GET['msg'];

$data=$db->selectStar("register");

$totalPage=ceil(sizeof($data)/10);
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

?>
<!DOCTYPE html>
<html>
<head>
	<title>Smart Card</title>
<link rel="stylesheet" href="css/bootstrap.min.css">	<style>
	button	{
		margin-right: 25px;
	}
		
	</style>
</head>
<body>
<div class="container">
<h3 style="color: red; "> <?=$info?> </h3>
<div class="print">
<style>


	.card{
	border: 1px solid ;
	position: relative;
	width: 8.85cm;
	height: 5.65cm;
	margin-bottom:0.05in;	
	margin-left: 0.2in;	
	float:left;

}
	
.A4{

	margin: auto;
	margin-top:0.1in;
			width:210mm ;
			height:297mm ;
			border: 1px solid ;
			border-radius: 10px;
}


img.profile{
	width: 0.68in;
	height: 0.725in;
	margin-top:82px;
	margin-left:40px;
}
ul.info{
	margin-left: 115px;
	margin-top:-93px;
	font-size: 8pt;
	}
ul.info>li{
	
	width: 97px;
	height: 20px;
	list-style: none;
	display: block;
	overflow: hidden;
	
}



img.qrCode{	
	width: 50px;
	height: 51px;
	margin-top: -125px;
	margin-left: 261px;
	box-shadow: 1px 1px 1px #000;
}
span.name{
	color:#f7941d;
	text-shadow: 1px 1px 1px #000000;
	display:block;
	margin-left: 5px;
	font-size: 11px;
	margin-top:1px;
	font-family:"Arial";
	width: 125px;
	text-align: center;
	overflow: hidden;
	height: 16px;	
}
span.id{
	margin-left:75px;
	color:whitesmoke;
	font-family: "OCR A Extended" ;
	font-size: 12px;
}
</style>

	<div class="A4"   data-pageno='1'>
	<div class="A4margin" style="margin-top: 0.2in; margin-left:0.2in;">
	<?php

	
	//if page 1  display 0 to 9 
		for ($i=0; $i<10; $i++){
			$pic="default.png";
		

			$id=$data[$i]["ID"];
			if(isset(glob("photo/$id.*")[0])){				
				$pic= glob("photo/$id.*")[0];
				
			}

			QRcode::png($id, "QRCode/$id.png", "L", "3", 2);
			$name=$data[$i]["Name"];
			$nrc=$data[$i]["NRC"];
			$region=trim($data[$i]["City"])." Region";
			$country=$data[$i]["Country"];
			$ph=$data[$i]["Phone"];
			$qr="QRCode/$id.png";

	displayCard($pic,$name,$id,$nrc,$region,$country,$ph,$qr);

		}
	?>
	</div>
	</div>
</div>
<h3 style="text-align: center"> Page <span class="page">1</span> of <?=$totalPage?> </h3>

	<div class="row">
		<div class="col-sm-offset-5" style="margin-top: 20px;">	
			<button id="print" class="btn btn-primary"> Print This Page</button>
		</div>	
	</div>
	<div class="row" style="margin-bottom: 30px;">
		<div class="col-sm-offset-8 ">
		  <button id="previous" class="btn btn-danger"> Previous </button>
	
			<button  id="next" class="btn btn-danger" > Next</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-5" style="margin-bottom:  20px;">	
			<a href="admin.php" class="btn btn-success"> BACK </a>
		</div>	
	</div>

</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script >
	$("#print").on('click',function(){
		var a4="<!DOCTYPE html><html><head><title>Printing Cards</title><link rel='stylesheet' href='css/bootstrap.min.css'></link>	</head><body> <div class='container'>"+$(".print").html()+'</div></body></html>';
	
		console.log(a4);
		var windowPrt=window.open('','','width=auto,height=auto,scrollbars=1,status=1,menubar=1');

		windowPrt.document.write(a4);
		windowPrt.focus();
		windowPrt.print();
	});

var cur=$("div.A4").data('pageno');
	$("#next").on('click',function(){
		
		$.post("action/next.php","current="+cur,function(data){
			cur+=1;
			
			$("span.page").html(cur);
			$("div.A4").attr("data-pageno",cur);
			
		
			$("div.A4margin").html(data);

		});
	});


	$("#previous").on('click',function(){
		cur=cur-1;
		$.post("action/previous.php","current="+cur,function(data){
			
			
			$("span.page").html(cur);
			$("div.A4").attr("data-pageno",cur);
			
		
			$("div.A4margin").html(data);

		});
	});
</script>
</body>
</html>