<!DOCTYPE html>
<html>
<head>
  <title>Registration </title>
    <meta charset="utf-8">   
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script type="text/javascript" src="js/jquery.min.js"></script>
       <script type="text/javascript" src="js/bootstrap.min.js"></script>
       <style >
       	h2,h3{
       		color: rgb(136,0,22);
       		text-align: center;
       	}
       </style>
</head>
<body>

<div class="container">
<div class="row" >
	<img src="img/header.jpeg" class="img-responsive" max-height="200px" width="100%" >
</div>
<div class="row">
	<h2> You Are Successfully Register</h2>
	<h3>Your Register ID is  <span style="color:blue; font-style:italic; font-weight:bold;font-size: 30px;"><?=$_GET['id'] ?></span> </h3> 
	<h3 style="color: red;">Please Remember ID For Identify Card.</h3>
</div>

</div>
</body>
</html>