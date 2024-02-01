<?php
include 'conex/config.php';
include 'conex/conexion.php';
include 'carrito.php';
include 'templates/header.php';
?>

<?php
if ($_POST) {
    $total = 0;
    $SID = session_id();
    $Correo = $_POST['email'];

    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
    }

    $sentencia = $pdo->prepare("
    INSERT INTO `ventas` (`ID`, `ClaveTransanccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
    VALUES (NULL, :ClaveTransanccion, '', NOW(), :Correo, :Total, 'Pendiente');
    ");
    $sentencia->bindParam(":ClaveTransanccion", $SID);
    $sentencia->bindParam(":Correo", $Correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->execute();
    $idVenta = $pdo->lastInsertId();

    foreach ($_SESSION['CARRITO'] as $indice => $producto) {

        $sentencia = $pdo->prepare("
        INSERT INTO `detalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
        VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');
        ");
        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $sentencia->execute();
    }

}
?>

<div class="text-center">
    <h1 class="display-4">
        Paso Final!
    </h1>
    <hr class="my-4">
    <p class="lead">
        Estas a punto de pagar con PayPal la cantidad de: 
        <h4>$<?php echo number_format($total,2) ?>.</h4>
    </p>
    <p>
        Los productos podrán ser descargados una vez se haya completado el pago.
    </p>
</div>

<!-- Parte del FOOTER -->
<?php
include 'templates/footer.php';
?>