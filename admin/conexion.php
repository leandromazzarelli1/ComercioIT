<?php
$host="localhost";
$db="comercio";
$user="root";
$pass="";
try{
    $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    

}catch(PDOException $e){
    echo "Error no conecto".$e->getMessage();
}