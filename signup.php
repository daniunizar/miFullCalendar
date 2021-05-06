<?php
    require 'db.php';
    $insercion=false;
    $mensaje_alerta = "";
    if(!empty($_POST['username'])){//Si al cargar esta página nos llegan por POST los valores de username y pass del formulario de SignUp
        //Lo intentamos agregar contectando con la BBDD.
        // echo "tenemos nombre";
        if(!empty($_POST['pass']) && !empty($_POST['confirm_pass']) && ($_POST['pass'])==($_POST['confirm_pass'])){
            // echo "Tenemos clave";
            // echo "Usuario procediendo a registrar";
            $a=new db();
            $insercion=$a->insertarUsuario();
        }else{
            $mensaje_alerta = "La contraseñas no coinciden";
            // echo "Error en las claves";
        }
        
    }else{
        // echo "Es la primera vez que accedes";
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSSs Importados-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>SignUp</title>
</head>
<body>
    <?php
        require 'partials/header.php';
    ?>
    <div class="container fondo_auxiliar_sobrepuesto" id="logo">
        <div class="row">
            <div class="col">
                <h1 class="centrado">SignUp</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="centrado">or <a href="login.php">Login</a></p>
            </div>
        </div>
        <div class="row"><!--Formulario signup-->
            <form action="" method="POST" class="formulario_signup" id="form_signup" name="form_signup">
                <div class="form-group centrado">
                    <input type="text" name="username" placeholder="Enter your Username*" class="form-control">
                </div>
                <div class="form-group centrado">
                    <input type="password" id="pass" name="pass" placeholder="Enter your Password*" class="form-control">
                </div>
                <div class="form-group centrado">
                    <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm your Password*" class="form-control">
                </div>
                <div id="alerta">
                    <p id="mensaje_alerta" class="mensaje_alerta"><?php echo $mensaje_alerta?></p>
                </div>
                <div class="form-group centrado col-12">
                    <input type="submit" value="Send" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
    <?php
        if($insercion==true){
            echo "<h1>Enhorabuena. Usuario Registrado. Ahora logeate para acceder.<span><a href='login.php'>Login</a></span></h1>";
        }
    ?>

</body>
</html>