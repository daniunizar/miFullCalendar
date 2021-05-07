<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSSs Importados-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/importStyles.css">
    <title>Calendapp</title>
</head>
<body>
    <?php
        require 'partials/header.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="centrado">Calendapp</h1>
            </div>
        </div>
        <?php if(empty($_SESSION['user_id'])):?><!--Si iniciamos la página sin habernos logueado mostramos el logo-->
        <div class="row mb-2 logo_index">
            <div class="col-12 text-center">
                <img src="assets/img/zodiac.png" alt="" width="500px">
            </div>
        </div>
        <?php endif;?><!--Fin de iniciar la página sin credenciales-->
        <div class="row">
            <div class="col-12">
                <?php if(empty($_SESSION['user_id'])):?><!--Si iniciamos la página sin habernos logueado-->
                    <div class="col-12">
                        <h2 class="centrado">Please, <a href="login.php">Login</a> or <a href="signup.php">SignUp</a></h2> 
                    </div>
                <?php else:?><!--Si nos hemos logueado con éxito-->
                    <?php
                        $a = new db(); 
                        $a->get_user_info()?>
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <h6 class="centrado">Bienvenid@ <?php echo $_SESSION['username']?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="centrado">Ya puedes usar tu calendario, o <a href="logout.php">Desloguearte</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php require 'calendar.php'?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>    
    
    
<!--BOOTSTRAP JS & JQ-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<!--END BOOTSTRAP JS & JQ-->
</body>
</html>