<?php  
 session_start();  
 $host = "localhost";  
 $username = "yoklamaadmin";  
 $password = "root1479";  
 $database = "yoklamasistemi";  
 $message = "";  
 try  
 {  
      $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>Kullanıcı adı ve şifre giriniz!</label>';  
           }  
           else  
           {  
                $query = "SELECT * FROM tbl_admin WHERE username = :username AND password = :password";  
                $statement = $connect->prepare($query);  
                $statement->execute(  
                     array(  
                          'username'     =>     $_POST["username"],  
                          'password'     =>     $_POST["password"]  
                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                     $_SESSION["username"] = $_POST["username"];  
                     header("location:index.php");  
                }  
                else  
                {  
                     $message = '<label>Kullanıcı adı veya şifre yanlış.</label>';  
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Admin Panel</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <style>
                body {
                   background: #f2f2f2; 



                }
           </style>
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
               
                <center><img src="./img/deulogo.png" height="250" width="300"></center>
                <h3 align="center">RFID Yoklama Admin Panel</h3><br />  
                 <?php  
                if(isset($message))  
                {  
                     echo '<center><label class="text-danger">'.$message.'</label></center>'; 
                }  
                ?>  
                <form method="post">  
                     <label>Kullanıcı Adı</label>  
                     <input type="text" name="username" class="form-control" />  
                     <br />  
                     <label>Şifre</label>  
                     <input type="password" name="password" class="form-control" />  
                     <br />  
                     <input type="submit" name="login" class="btn btn-info" value="Login" />  
                </form>  
           </div>  
           <br />  
      </body>  
 </html>  