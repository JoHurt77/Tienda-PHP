<?php
include 'conex/config.php';
include 'carrito.php';
include 'templates/header.php';
?>

<br>
<div class="container">
    <h3 class="text-center">Lista Carrito</h3>

    <!-- PREGUNTAMOS SI EL CARRITO ESTA VACIO: -->
    <?php if (!empty($_SESSION['CARRITO'])) { ?>
        <table class="table table-primary table-bordered">
            <tbody>
                <tr>
                    <th width="40%">Descripción</th>
                    <th width="15%" class="text-center">Cantidad</th>
                    <th width="20%" class="text-center">Precio</th>
                    <th width="20%" class="text-center">Total</th>
                    <th width="5%">--</th>
                </tr>
                <!-- CUERPO DE LA TABLA USANDO FOREACH -->
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                    <tr>
                        <td width="40%"><?php echo $producto['NOMBRE']; ?></td>
                        <td width="15%" class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                        <td width="20%" class="text-center">$<?php echo $producto['PRECIO']; ?></td>
                        <td width="20%" class="text-center">$<?php echo number_format($producto['CANTIDAD'] * $producto['PRECIO'], 2); ?></td>
                        <td width="5%">
                            <form action="" method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                <button type="submit" class="btn btn-danger" name="btnAction" value="Eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total = $total + ($producto['CANTIDAD'] * $producto['PRECIO']); ?>
                <?php } ?>
                <tr>
                    <td colspan="3" align="right">
                        <h3>Total</h3>
                    </td>
                    <td align="right">
                        <h3><?php echo number_format($total, 2); ?></h3>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <form action="pagar.php" method="post">
                            <div class="alert alert-success">
                                <div class="form-group">
                                    <label for="my-input">Correo de contacto: </label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="@mail.com" required>
                                    <small id="emailHelp" class="form-text text-muted">Los productos se enviarán a este correo.</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="btnAction" value="proceder">
                                Proceder a pagar
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-success">
            No hay productos en el carrito...
        </div>
    <?php } ?>
</div>

<!-- Parte del FOOTER -->
<?php
include 'templates/footer.php';
?>