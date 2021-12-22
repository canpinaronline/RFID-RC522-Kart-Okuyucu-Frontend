<nav class="navbar navbar-dark bg-dark"> <!-- Header Başlangıç -->
        <a href="index.php" class="navbar-brand nav-link active"><img src="./img/deulogo.png" width="30" height="30"> Yoklama Sistemi</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="attendance.php" class="nav-link">Yoklama Kayıtları</a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link">Öğrenciler</a>
            </li>
            <li class="nav-item"><?php  
 
                      
                     if(isset($_SESSION["username"]))  
                     {  
                          echo '<p class="text-light nav-link active">Hoşgeldin '.$_SESSION["username"].'</p>';  
                           
                     }  ?>  </li>
                           
             <li class="nav-item"><?php echo "<p id='logout' class='text-light nav-link'><a href='logout.php'>Çıkış Yap</a></p>"; ?></li>            
        </ul>
    </nav> <!-- Header Bitiş -->