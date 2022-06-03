<?php
require "../db/config.php";
require "../db/database.php";
$db=new Database($config);
$id=$_POST['id'];



$db->delete("register","ID='$id'");

echo "true";



?>