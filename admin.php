<?php 
session_start();
require "db/config.php";
require "db/database.php";
$db=new Database($config);
if($_SESSION["admin"]!="success"){
	header("Location:index.php");
	}

$data=$db->selectStar("register");
//to delete users
$info=@$_GET['msg'];
?>


<!DOCTYPE html>
<html>
<head>
  <title>Sayam  </title>
    <meta charset="utf-8">   
      <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css"> 
    <link rel="stylesheet" href="css/responsive.dataTables.min.css">


</head>
<body>
<div class="container">
<h3 style="color: red; text-align: center; "> <?=$info?> </h3>

      <div class="page-header">
        <h1>Registered Users </h1>
      </div>

      
          <table id="myTable" class="table table-bordered table-hover" >
              <thead>
                  <tr>
                      <th>Registration Number</th>
                      <th>Full Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>NRC or Passport Number</th>
                      <th>Country</th>
                      <th>City</th>
                      <th>Email</th>
                      <th>Phone Number </th>
                      <th>Date</th>
                      <th>Father's Name</th>
                      <th>Address</th>
                      <th>Delete</th>
                      <th>Edit</th>
                      


                  </tr>
              </thead>
              <tbody>

              <?php 


              foreach($data as $value): ?> 
                    <tr id="id<?=$value['ID']?>">
                        <td><?=$value['ID']?></td>
                        <td><?= $value['Name'] ?></td>
                        <td><?= $value['Age'] ?></td>
                        <td><?= $value['Gender'] ?></td>
                        <td><?= $value['NRC'] ?></td>
                        <td><?= $value['Country'] ?></td>
                        <td><?= $value['City'] ?></td>
                        <td><?= $value['Email'] ?></td>
                        <td><?= $value['Phone'] ?></td>
                        <td><?= $value['Today_Date'] ?></td>
                        <td><?= $value['Father_Name'] ?></td>
                        <td><?= $value['Address'] ?></td>
                        <td><button class="btn btn-danger" onclick="mohan('<?=$value["ID"]?>')" id="deleteBtn" data-id="<?=$value['ID']?>"> Delete </button> </td>
                        <td><a class="btn btn-success"  href="edit.php?id=<?=$value['ID']?>"> Edit </a> </td>

                       
                        

                    </tr>
              <?php endforeach; ?>

              </tbody>
          </table>
   <a class="btn btn-primary" href="smartcard.php">Create Smart Card </a>   
   <div class="row">
    <div class="col-sm-offset-5" style="margin-bottom:  20px;"> 
      <a href="index.php" class="btn btn-danger"> LOG OUT </a>
    </div>  
  </div>
</div>


</body>

<script type="text/javascript" src="js/jquery.min.js"></script>



     
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="js/dataTables.responsive.min.js" type="text/javascript" ></script>

<script>
   
function mohan(id){
  var i=window.confirm("Are You sure want to Delete this User ?");
    if(i){

      $.post("action/deleteRow.php","id="+id,function(data){

        if(data=="true"){
          var tdE="id"+id;
          var e1=document.getElementById(tdE);
          e1.nextElementSibling.remove();
          e1.remove();

        }

      });

    }
}




            $('#myTable').DataTable(
                {
                    responsive: true
                }
            );



</script>

</html>

