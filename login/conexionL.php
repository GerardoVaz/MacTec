<?php
function connect(){
    $conn = null;
    $host = "localhost:3306"; //host donde esta la base de datos
    $db = "tienda"; //nombre de BD
    $user = "root"; // user name
    $pwd = ""; // password de usuario

    try {
        $conn = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pwd);
        //echo ':) Éxito ';
      }catch(PDOException $e){
        echo ':( Error al conectar con la base de datos '.$e;
        exit;
      }
    
    return $conn;
}
?>