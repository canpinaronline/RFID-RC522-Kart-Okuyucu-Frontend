<?php
require 'common.php';

//Grab all the users from our database
$users = $database->select("users", [
    'id',
    'name',
    'rfid_uid',
    'ogr_bol',
    'ogr_sin'
]);

?>
<?php  session_start(); ?>  
<?php if(!isset($_SESSION["username"])){
 
echo "Bu sayfayı görüntüleme yetkiniz yoktur.";
header("location:login.php");  
}?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Öğrenciler | Yoklama Sistemi</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-dark bg-dark"> <!-- Header Başlangıç -->
        <a href="index.php" class="navbar-brand nav-link active"><img src="./img/deulogo.png" width="30" height="30"> Yoklama Sistemi</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="attendance.php" class="nav-link">Yoklama Kayıtları</a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link active">Öğrenciler</a>
            </li>
            <li class="nav-item"><?php  
 
                      
                     if(isset($_SESSION["username"]))  
                     {  
                          echo '<p class="text-light nav-link">Hoşgeldin '.$_SESSION["username"].'</p>';  
                           
                     }  ?>  </li>
                           
             <li class="nav-item"><?php echo "<p id='logout' class='text-danger nav-link'><a href='logout.php'>Çıkış Yap</a></p>"; ?></li>            
        </ul>
    </nav> <!-- Header Bitiş -->
    <div class="container">
        <div class="row">
            <h2>Kullanıcılar</h2>
        </div>
        
        </br>
        <table class="table table-striped table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">İsim</th>
                    <th scope="col">RFID UID</th>
                    <th scope="col">Bölüm</th>
                    <th scope="col">Sınıf</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through and list all the information of each user including their RFID UID
                foreach($users as $user) {
                    echo '<tr>';
                    echo '<td scope="row">' . $user['id'] . '</td>';
                    echo '<td>' . $user['name'] . '</td>';
                    echo '<td>' . $user['rfid_uid'] . '</td>';
                    echo '<td>' . $user['ogr_bol'] . '</td>';
                    echo '<td>' . $user['ogr_sin'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    <?php

    try{//hata varmı diye kontrol mekanizması.

        $baglanti=new PDO("mysql:host=localhost;dbname=attendancesystem","attendanceadmin","pimylifeup");//bağlantı yaptık

        echo "<b>Veritabanı bağlantı durumu:</b> <span style='color:lime'><b>Başarılı</b></span><br />";//bağlantı varsa ekrana yaz.

        $cek=$baglanti->query("select *  from users");//uye tablosundki tüm verileri çek 

        $veri_miktar=$cek->rowCount();//verilerin hepsini say.

            if($veri_miktar>0){//veri vars miktarını yaz

                echo "<b>Kayıtlı öğrenci sayısı :</b>".$veri_miktar."<br /><br />";     

            }else{

                echo "Hiç veri yok";

            }


    }catch (PDOException $h) {

        $hata=$h->getMessage();

        echo "<b>Bağlantı hatası.</b> ".$hata;

    }

    ?>

    

    </div>
</html>