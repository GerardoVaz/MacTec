<?php 
    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MacTec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
include 'global/conexion3.php';

$sentenciaSQL = $conexion->prepare("SELECT * FROM compra");
$sentenciaSQL->execute();
$compra=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

include 'carrito.php';
include 'global/config.php';
include 'global/conexion.php';
?>


<table class="table table-light table-bordered">
        <tbody>
            <tr>
                <th width=40%>Descripción</th>
                <th width=15% class="text-center">Cantidad</th>
                <th width=20% class="text-center">Precio</th>
                <th width=20% class="text-center">Subtotal</th>
            </tr>
            <?php foreach($_SESSION['CARRITO'] as $indice=>$producto){?>
            <tr>
                <td width=40%><?php echo $producto['NOMBRE']?></th>
                <td width=15% class="text-center"><?php echo $producto['CANTIDAD']?></th>
                <td width=20% class="text-center"><?php echo $producto['PRECIO']?></th>
                <td width=20% class="text-center"><?php echo number_format($producto['PRECIO']*$producto['CANTIDAD'],2)?></th>
                </form>
            </tr>
            <?php } ?>
            <tr>
    </table>
</body>
</html>

<?php 
    $html=ob_get_clean();
    //echo $html;

    require_once 'libreria/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter');

    $dompdf->render();
    $dompdf->stream("archivo.pdf", array("Attachment"=>false));
?>