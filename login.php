<?php
    session_start();
    $is_logged=false;
        require 'db.php';
        if(!empty($_POST['username'])){
            if(!empty($_POST['pass'])){
                $a=new db();
                $is_logged=$a->login();
            }
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

    <link rel="stylesheet" href="assets/css/importStyles.css">
    <title>Login</title>
</head>
<body>
    <?php require 'partials/header.php';?>
    <div class="container">
        <div class="row">
            <div class="col.12"><!--título-->
                <h1 class="centrado">Login</h1>
            </div>
        </div>
        <div class="row"><!--Subtítulo-->
            <div class="col-12">
                <p class="centrado">or <a href="signup.php" class="centrado">SignUp</a></p>
            </div>
        </div>
        <div class="row"><!--Formulario login-->
            <form action="" method="POST" class="formulario_login">
                <div class="form-group centrado">
                    <input type="text" name="username" placeholder="Enter your Username*" class="form-control">
                </div>
                <div class="form-group centrado">
                    <input type="password" name="pass" placeholder="Enter your Password*" class="form-control">
                </div>
                <div class="form-group centrado col-12">
                    <input type="submit" value="Send" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
    <?php
        if($is_logged==true){
            echo "<h1>Enhorabuena, estás loggeado.</h1>";
            header('Location: index.php');
        }else{
            // echo "Error en el loggeo";
        }
    ?>
</body>
</html>