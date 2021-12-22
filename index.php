<?php
require 'common.php';
?>
<?php  session_start(); ?>  
<?php if(!isset($_SESSION["username"])){
 
echo "Bu sayfayı görüntüleme yetkiniz yoktur.";
header("location:login.php");  
}?>
 

<!DOCTYPE html>
<html lang="tr">
    <head>
        <title>Yoklama & Turnike Sistemi</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
        
    </head>
    <body>

        <?php include 'header.php' ?>
    
    <div class="container">
       <center> <div class="col-md-6 order-md-1 text-center text-md-left pr-md-5"></br>
            
            <p class="lead text-center">
                RFID Yoklama Sistemi Kontrol Paneli
            </p>
            <center><img src="./img/deulogo.png" height="250" width="250"></center><br>
            <div class="row mx-n2">
                <div class="col-md px-2">
                    <a href="users.php" class="btn btn-lg btn-outline-secondary w-100 mb-3">Öğrenciler</a>
                </div>
                <div class="col-md px-2">
                    <a href="attendance.php" class="btn btn-lg btn-outline-secondary w-100 mb-3" >Yoklama Kayıtları</a>
                </div>
            </div>
        </div>
    </center>
    </div>
</html>

