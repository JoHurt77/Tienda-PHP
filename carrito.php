<?php
session_start();

$mensaje = "";

if (isset($_POST['btnAction'])) {
    switch ($_POST['btnAction']) {
        case 'Agregar':
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                $mensaje .= "OK ID correcto" . $ID . "<br/>";
            } else {
                $mensaje .= "Error... ID incorrecto";
            }
            if (is_string(openssl_decrypt($_POST['nombre'], COD, KEY))) {
                $NOMBRE = openssl_decrypt($_POST['nombre'], COD, KEY);
                $mensaje .= "OK Nombre correcto" . $NOMBRE . "<br/>";
            } else {
                $mensaje .= "Error... Nombre incorrecto" . "<br/>";
            }
            if (is_numeric(openssl_decrypt($_POST['cantidad'], COD, KEY))) {
                $CANTIDAD = openssl_decrypt($_POST['cantidad'], COD, KEY);
                $mensaje .= "OK cantidad correcto" . $CANTIDAD . "<br/>";
            } else {
                $mensaje .= "Error... Cantidad incorrecto" . "<br/>";
            }
            if (is_numeric(openssl_decrypt($_POST['precio'], COD, KEY))) {
                $PRECIO = openssl_decrypt($_POST['precio'], COD, KEY);
                $mensaje .= "OK Precio correcto" . $PRECIO . "<br/>";
            } else {
                $mensaje .= "Error... Precio incorrecto" . "<br/>";
            }

            if (!isset($_SESSION['CARRITO'])) {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO,
                );
                $_SESSION['CARRITO'][0] = $producto;
                $mensaje = "Producto agregado al carrito!";
            }else {

                $idProductos=array_column($_SESSION['CARRITO'],"ID");
                if (in_array($ID,$idProductos)) {
                    echo "<script>alert('El producto ya ha sido agregado al carrito')</script>";
                    $mensaje="";
                }else {
                    
                    $NumeroProductos = count($_SESSION['CARRITO']);
                    $producto = array(
                        'ID' => $ID,
                        'NOMBRE' => $NOMBRE,
                        'CANTIDAD' => $CANTIDAD,
                        'PRECIO' => $PRECIO,
                    );
                    $_SESSION['CARRITO'][$NumeroProductos] = $producto;
                    $mensaje = "Producto agregado al carrito!";
                }
            }
            //$mensaje = print_r($_SESSION, true);
            

            break;

        case 'Eliminar':
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        //Provisional
                        $_SESSION['CARRITO'] = array_values($_SESSION["CARRITO"]);
                        echo "<script>alert('Producto borrado');</script>";
                        //Provisional
                        break;
                    }
                }
            } else {
                $mensaje .= "Error... ID incorrecto" . $ID . "<br/>";
            }
            break;
    }
}
