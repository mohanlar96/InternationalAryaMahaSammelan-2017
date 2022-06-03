<?php
session_start();
session_destroy();
require "db/config.php";
require "db/database.php";
$db=new Database($config);
if(!$db->is_exist("register")){
  $db->query("
  CREATE TABLE register (
  ID int(11) NOT NULL,
  Name varchar(30) COLLATE utf8_general_ci ,
  Father_Name varchar(30) COLLATE utf8_general_ci ,
  Age int(11) ,
  Gender varchar(7) COLLATE utf8_general_ci ,
  Today_Date varchar(12) COLLATE utf8_general_ci ,
   NRC varchar(30) COLLATE utf8_general_ci,
  Address varchar(50) COLLATE utf8_general_ci ,
  City varchar(30) COLLATE utf8_general_ci ,
  Country varchar(30) COLLATE utf8_general_ci ,
  Email varchar(30) COLLATE utf8_general_ci ,
  Phone varchar(20) COLLATE utf8_general_ci 
);
");
  $db->query("
  ALTER TABLE register
  ADD PRIMARY KEY (ID);
  ");
  $db->query("
  ALTER TABLE register
  MODIFY ID int(11) NOT NULL AUTO_INCREMENT;
  ");
}
$Today_Date=Date("m/d/Y");

$data=$db->selectStar("register");

if(!is_array(end($data))){
  $id="1234";
}else{
  $id=end($data)['ID'] + 1 ;
  
}




if(isset($_POST['submit'])){

$name=$_POST['name'];
$fname=$_POST['fname'];
$age=$_POST['age'];
$gender=@$_POST['gender'];
$nrc=$_POST['NRC'];
$address=$_POST['address'];
$city=$_POST['city'];
$country= $_POST['country'];
$email=$_POST['email'];
$ph_no=$_POST['ph_no'];
$msg="";

if(explode('/',$_FILES["image"]["type"])[0] != "image"){
 $msg.= " Please Upload Your Correct Photo File.<br>";
}

function lengthCheck($data){
  if(strlen($data) >= 4 ){
    
    return 1;

  }else{ return 0;
    }
}


if( lengthCheck($_POST['name']) AND lengthCheck(@$_POST['gender']) AND lengthCheck($_POST['fname'])   AND lengthCheck($_POST['address']) AND lengthCheck($_POST['city']) AND lengthCheck($_POST['country'])AND $_POST['age']!=""){
if($db->is_data("select * from register where NRC='$nrc'")){
  $msg.=" Your NRC or Passport No is already register ";
}else{

  $data=$db->selectStar("register");
  if(!is_array(end($data))){
    $id="1234";
  }else{
    $id=end($data)['ID'] + 1 ;
  }

$db->query("INSERT INTO register (ID, Name, Father_Name, Age, Gender, Today_Date, NRC, Address, City, Country, Email, Phone) VALUES ('$id', '$name', '$fname', '$age', '$gender', '$Today_Date', '$nrc', '$address', '$city', '$country', '$email', '$ph_no')");


$temp_name=$_FILES["image"]["tmp_name"];
$name=$_FILES["image"]["name"];
move_uploaded_file($temp_name, "photo/$name");
rename("photo/$name", "photo/$id.png");
unset($_FILES);
unset($_POST);
header("Location:success.php?id=$id");

}



}else{

  $msg.= "Please Fill Everything Correctly !<br>";
}


}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Registration </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>
        .login_bg,
        .btn-primary {
            background-color: rgb(136, 0, 22);
            color: white;
        }
    </style>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body>

    <!-- Modal -->
    <div id="myModal" class="modal fade " role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login_bg">
                    <button type="button" class="close" data-dismiss="modal" style="font-size: 33px;font-weight: bold;color: rgb(255, 255, 255);text-shadow: 1px 1px 9px black;">&times;</button>
                    <h4 class="modal-title">Please Login</h4>
                </div>
                <div class="modal-body ">
                    <form class="form-horizontal" id="login" action="#" method="POST" role="form">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="username">Username:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="name" placeholder="Enter Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-xs-offset-2 col-xs-3" ">
                                                  <button type="submit " name="login" value="Login" class="btn btn-primary Submit ">Login</button>
                                                </div>
                                              </div>
                                              <div class="form-group ">
                                                <div id="loginMsg" class="col-sm-offset-2 col-sm-10 " style="color:red; ">

                                                   </div>

                                              </div>

                                            </form>
                                          </div>

                                        </div>

                                      </div>
                                    </div>

<div class="container ">
<div class="row " >

	<img src="img/header.jpeg " class="img-responsive " max-height="200px " width="100% " >
</div>

<div class="row " style="background-color:rgb(252, 138, 39); " >
		<h1 style="text-align:center; color: rgb(136,0,22); ">Registration</h1>
        <div class="row" style="margin-left: 20px;margin-right: 12px;">
            <h4 class="pull-left">Registration No - <?=" ".$id ?> </h4>
            <h4 class="pull-right">Today Date - <?=" ".$Today_Date ?>  </h4>
            
        </div>

	<div class="col-sm-12 " style="margin-left: 5px;margin-right: 5px;">
		 <form accept="image/*" enctype ="multipart/form-data"  role="form" method="POST" action="#">

                      <div class="form-group ">
                        <div class="col-sm-offset-2 col-sm-10 ">
                        <p style="color: yellow;font-weight: bold;font-style: italic; "><?=@$msg?></p>
                        </div>
                      </div>
                    <div class="row" >
                      <div class="col-sm-6" >
                        <div class="form-group ">
                            <label for="name ">Full Name :</label>

                            <input type="text" name="name" class="form-control " id="name " value="" placeholder="eg: Kapil Sharmar" required>

                        </div>
                    </div>

                     <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="img">Your Photo :</label>
                           <input type="file" accept="image/*" name="image" id="img" >
                           
                        </div>
                      </div>
                    </div>

                    <div class="row" >
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">Age :</label>
                            
                                <select class="form-control" name="age" id="age">
                                    <option value=''> - - Your Age - - </option>
                                    <?php
                                        for($i=15; $i<=100; $i++){
                                        echo "<option value='$i'> $i </option> ";

                                        }
                                        ?>
                                </select>
                            
                        </div>
                      </div>

                    
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="fname">Father's Name :</label>
                            
                            <input type="text" value="" name="fname" class="form-control" id="fname" placeholder="Your Father Name Please" >
                            
                        </div>
                      </div>
                    </div>

                    <div class="row" >

                      <div class="col-sm-6">

                        <div class="form-group">
                            <label  for="gender">Gender : </label>
                            <div >
                                <input type="radio" name="gender" value="Male" id="Male">
                                <label for="Male">Male</label>
                                <input type="radio" name="gender" value="Female" id="Female">
                                <label for="Female">Female</label>
                                <input type="radio" name="gender" value="Other" id="Other">
                                <label for="Other">Other</label>

                            </div>
                        </div>
                      </div>



                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="address">Address :</label>
                            
                            <input type="address" value="" name="address" class="form-control" id="address" placeholder="Please Enter Address">
                            
                        </div>
                      </div>


                  </div>

                  <div class="row" >

                  <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="NRC">NRC or Passport No :</label>
                            
                            <input type="text" value="" name="NRC" class="form-control" id="NRC" placeholder=" 9/MKN (N) 134649 ">
                           
                        </div>
                   </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="country">Country :</label>
                            
                                <input type="text" value="" name="country" class="form-control" id="country" placeholder="Please Enter Country ">
                           
                        </div>
                      </div>

                  </div>
                  <div class="row" >

                  <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="email">Email:</label>
                            
                            <input type="text" value="" name="email" class="form-control" id="email" placeholder="example@yahoo.com">
                            
                        </div>
                  </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="city">City :</label>
                            
                            <input type="text" value="" name="city" class="form-control" id="city" placeholder="Please Enter City">
                            
                        </div>
                      </div>

                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="ph_no">Phone :</label>
                            
                                <input type="text" value="" name="ph_no" class="form-control" id="ph_no" placeholder="+95 940 251 7177">
                           
                        </div>
                      </div>
                  </div>

                    <div class="row">
                        <div class="form-group">
                            <div class=" col-sm-6">
                                <button style="background-color: rgb(136,0,22); color: #fff;" type="submit" name="submit"  class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </div>
            </form>
                    <div class="row" style="margin-right: 2px;">
                        <button class="btn btn-danger pull-right" href="#myPage" data-toggle="modal" data-target="#myModal"> Admin</button>
                    </div>
                </div>

            </div>

        </div>
        <script type="text/javascript" src="js/login.js"></script>
</body>

</html>