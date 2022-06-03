<?php 
session_start();
require "db/config.php";
require "db/database.php";
$db=new Database($config);
if($_SESSION["admin"]!="success"){
	header("Location:index.php");
	}
	$id=$_GET['id'];
$data=$db->get("register","ID='$id'");

if(isset(glob("photo/$id.*")[0])){				
				$pic= glob("photo/$id.*")[0];
				
			}else{
				$pic="photo/default.png";
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





 $db->query("delete from register where ID='$id'");

$db->query("INSERT INTO register (ID, Name, Father_Name, Age, Gender, Today_Date, NRC, Address, City, Country, Email, Phone) VALUES ('$id', '$name', '$fname', '$age', '$gender', '$Today_Date', '$nrc', '$address', '$city', '$country', '$email', '$ph_no')");

header("Location:admin.php?msg=Successfully Edited");


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

<div class="container ">


<div class="row " style="background-color:rgb(252, 138, 39); " >
		<h1 style="text-align:center; color: rgb(136,0,22); ">Edit  <b style="color:white;"> <i> <?=$data[0]["Name"]?> </b> </i></h1>
        <div class="row" style="margin-left: 20px;margin-right: 12px;">
            <h4 class="pull-left">Registration No - <?=" ".$id ?> </h4>
            <h4 class="pull-right">Registered Date - <?=" ".$data[0]["Today_Date"] ?>  </h4>
            
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

                            <input type="text" name="name" class="form-control " id="name " value="<?=$data[0]['Name']?>" placeholder="eg: Kapil Sharmar" required>

                        </div>
                    </div>

                     <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="img"> Photo :</label>
                            <img src="<?=$pic?>" style="width: 200px;height: 200px;">
                           
                           
                        </div>
                      </div>
                    </div>

                    <div class="row" >
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">Age :</label>
                            
                                <select value="<?=$data[0]['Age']?>" class="form-control" name="age" id="age">
                                   
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
                            
                            <input type="text" value="<?=$data[0]['Father_Name']?>" name="fname" class="form-control" id="fname" placeholder="Your Father Name Please" >
                            
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
                             <?php
                            $gender=$data[0]['Gender'];
                            echo "<script>
                            document.forms[0].gender.value='$gender';

                            </script>" 
                            ?>
                        </div>
                      </div>



                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="address">Address :</label>
                            
                            <input type="address" value="<?=$data[0]['Address']?>" name="address" class="form-control" id="address" placeholder="Please Enter Address">
                            
                        </div>
                      </div>


                  </div>

                  <div class="row" >

                  <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="NRC">NRC or Passport No :</label>
                            
                            <input type="text" value="<?=$data[0]['NRC']?>" name="NRC" class="form-control" id="NRC" placeholder=" 9/MKN (N) 134649 ">
                           
                        </div>
                   </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="country">Country :</label>
                            
                                <input type="text" value="<?=$data[0]['Country']?>" name="country" class="form-control" id="country" placeholder="Please Enter Country ">
                           
                        </div>
                      </div>

                  </div>
                  <div class="row" >

                  <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="email">Email:</label>
                            
                            <input type="text" value="<?=$data[0]['Email']?>" name="email" class="form-control" id="email" placeholder="example@yahoo.com">
                            
                        </div>
                  </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="city">City :</label>
                            
                            <input type="text" value="<?=$data[0]['City']?>" name="city" class="form-control" id="city" placeholder="Please Enter City">
                            
                        </div>
                      </div>

                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label  for="ph_no">Phone :</label>
                            
                                <input type="text" value="<?=$data[0]['Phone']?>" name="ph_no" class="form-control" id="ph_no" placeholder="+95 940 251 7177">
                           
                        </div>
                      </div>
                  </div>

                    <div class="row">
                        <div class="form-group">
                            <div class=" col-sm-6">
                                <button style="background-color: rgb(136,0,22); color: #fff;" type="submit" name="submit"  class="btn btn-default">Edit</button>
                            </div>
                        </div>
                    </div>
            </form>
                    <div class="row" style="margin-right: 2px;">
                        <a class="btn btn-danger pull-right" href="admin.php" > Back</a>
                    </div>
                </div>

            </div>

        </div>
</body>
</html>