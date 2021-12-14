<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>

<?php
if($_POST){
    $total=0;
    $SID=session_id();
    $Correo=$_POST['email'];


    foreach($_SESSION['CARRITO']  as $indice=>$producto){
        $total=$total+($producto['PRECIO'] * $producto['CANTIDAD']);
    }

        $sentencia=$pdo->prepare("INSERT INTO `tblventas` 
                        (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
                        VALUES (NULL,:ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
        
        $sentencia->bindParam(":ClaveTransaccion",$SID);
        $sentencia->bindParam(":Correo",$Correo);
        $sentencia->bindParam(":Total",$total);
        $sentencia->execute();
        $idVenta=$pdo->lastInsertId();

        foreach($_SESSION['CARRITO']  as $indice=>$producto){

            $sentencia=$pdo->prepare("INSERT INTO 
            `tbldetallaventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
            VALUES (NULL,:IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");

            $sentencia->bindParam(":IDVENTA",$idVenta);
            $sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
            $sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
            $sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
            $sentencia->execute();
        }

    //echo "<h3>".$total."</h3>";
}
?>



<div class="jumbotron text-center">
    <h1 class="display-4">¡Paso Final!</h1>
    <hr class="my-4">
    <p class="lead"> Estas a punto de pagar con PayPal la cantidad de:
       <h4>$<?php echo number_format($total,2); ?> </h4> 
       <div id="paypal-button-container"></div>
    </p>
    <p>Los Productos seran enviados una vez que se procese el pago por PayPal</br>
    <strong>(Para alguna aclaracion: luisvega.vega0606@gmail.com)</strong>
    </p>


</div>

    <!--------------------------------------paypal------------------------------------------------------->
 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> PayPal Checkout Integration | Responsive Buttons </title>

    <style>
        /* Media query for mobile viewport */
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
        
        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
            }
        }
    </style>
</head>


<body>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons().render('#paypal-button-container');

    </script>
</body>

</html>
    

<!--final paypal-->


<?php include 'templates/pie.php'; ?>