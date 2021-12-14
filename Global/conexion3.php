<?php
    $host="localhost";
    $bd="samsung store";
    $usuario="root";
    $contra="";

    try{
        $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contra);
    if($conexion){ /*echo "Conectado... a sistema";*/}
    } catch(Exception $ex){
        echo $ex->getMessage();
    }