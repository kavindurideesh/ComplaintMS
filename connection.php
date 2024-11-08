<?php
$hostname="10.10.10.157";
$username="csc210user";
$password="CSC210!";
$dbname="group10";
$con=mysqli_connect($hostname,$username,$password,$dbname);
if(!$con)
{
    //echo "connection failed:".mysqli_connect_error($con);

}



?>
