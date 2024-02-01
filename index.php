<?php
include 'conex/config.php';
include 'conex/conexion.php';
include 'carrito.php';
include 'templates/header.php';
?>

<!-- Header en template/header.php -->
<?php if($mensaje!="") {?>
<div class="container">
  <div class="alert alert-success" role="alert">
    <?php print $mensaje; ?>
    <a href="mostrarCarrito.php">Ver Carrito</a>
  </div>
</div>
<?php } ?>
<main>
  <div class="row justify-content-center align-items-center g-2">
    <?php
    $sentencia = $pdo->prepare("SELECT * FROM `productos`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //print_r($listaProductos);
    ?>
    <!--Un bucle para colocar las posiciones de los arrays de productos. Finaliza en la linea 63 col 7 -->
    <?php foreach ($listaProductos as $producto) { ?>

      <div class="col-3">
        <div class="card text-start">
          <img class="card-img-top" src="<?php echo $producto['Imagen']; ?>" alt="<?php echo $producto['Nombre']; ?>" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<?php echo $producto['Nombre']; ?>" data-bs-content="<?php echo $producto['Descripcion']; ?>">
          <div class="card-body">
            <span><?php echo $producto['Nombre']; ?></span>
            <h4 class="card-title">$<?php echo $producto['Precio']; ?></h4>
            <p class="card-text">Descrpipción</p>

            <!--FORM CON METODO POST PARA ENVIAR LOS DATOS DEL LIBRO. QUE ESTAN ENCRIPTADOS -->
            <form action="" method="post">

              <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
              <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
              <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
              <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">

              <button class=" btn btn-primary" type="submit" name="btnAction" value="Agregar">Añadir al carrito</button>

            </form>
          </div>
        </div>
      </div>

    <?php } ?>

  </div>
</main>

<!-- Parte del FOOTER -->
<?php
include 'templates/footer.php';
?>
