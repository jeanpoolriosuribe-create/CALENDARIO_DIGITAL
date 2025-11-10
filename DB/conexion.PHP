<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendario_digital";

//crear conexion 
$conn = new mysqli($servername,$username,$password,$dbname);

//verificar conexion
if ($conn->connect_error){
  die ("conexion fallida. " . $conn->connect_error);
}
?>



