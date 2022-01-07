<?php
require 'common.php';

//Grab all users from our database
$users = $database->select("users", [
    'id',
    'name',
]);

//Check if we have a year passed in through a get variable, otherwise use the current year
if (isset($_GET['year'])) {
    $current_year = int($_GET['year']);
} else {
    $current_year = date('Y');
}

//Check if we have a month passed in through a get variable, otherwise use the current year
if (isset($_GET['month'])) {
    $current_month = $_GET['month'];
} else {
    $current_month = date('n');
}

//Calculate the amount of days in the selected month
$num_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

?>
<?php  session_start(); ?>  
<?php if(!isset($_SESSION["username"])){
 
echo "Bu sayfayı görüntüleme yetkiniz yoktur.";
header("location:login.php");  
}?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kayıtlar | Yoklama Sistemi</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <meta charset="utf-8">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-dark bg-dark"> <!-- Header Başlangıç -->
        <a href="index.php" class="navbar-brand nav-link active"><img src="./img/deulogo.png" width="30" height="30"> Yoklama Sistemi</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="attendance.php" class="nav-link active">Yoklama Kayıtları</a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link">Öğrenciler</a>
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
            <h2>Attendance</h2>
        </div>
        <center><p><?php
                // Zamanı Türkiye'ye göre ayarladık.
                date_default_timezone_set('Europe/Istanbul');

                //Dili Türkçe ayarladık. Tabi diğer sunucunuzda kurulu olduğu sürece ülkelerin dillerini de ayarlayabilirsiniz.
                setlocale(LC_TIME, 'turkish.UTF-8');

                echo strftime('%e %B %Y %A');
                
                ?>
        </p></center>
        <table class="table table-striped table-light table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">İsim</th>
                    <?php
                        //Generate headers for all the available days in this month
                        for ( $iter = 1; $iter <= $num_days; $iter++) {
                            echo '<th scope="col" style="min-width:250px;max-width:350px;">' . $iter . '</th>';
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Loop through all our available users
                    foreach($users as $user) {
                        echo '<tr>';
                        echo '<td scope="row">' . $user['name'] . '</td>';

                        //Iterate through all available days for this month
                        for ( $iter = 1; $iter <= $num_days; $iter++) {
                            
                            //For each pass grab any attendance that this particular user might of had for that day
                            $attendance = $database->select("attendance", [
                                'clock_in'
                            ], [
                                'user_id' => $user['id'],
                                'clock_in[<>]' => [
                                    date('Y-m-d', mktime(0, 0, 0, $current_month, $iter, $current_year)),
                                    date('Y-m-d', mktime(24, 60, 60, $current_month, $iter, $current_year))
                                ]
                            ]);

                            //Check if our database call actually found anything
                            if(!empty($attendance)) {
                                //If we have found some data we loop through that adding it to the tables cell
                                echo '<td class="table-success">';
                                foreach($attendance as $attendance_data) {
                                    echo 'Tarih: ' . $attendance_data['clock_in'] . '</br>';
                                }
                                echo '</td>';
                            } else {
                                //If there was nothing in the database notify the user of this.
                                echo '<td class="table-secondary">Kayıt bulunamadı.</td>';
                            }
                        }
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</html>
