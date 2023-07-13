<!-------------------------------------------------------------------
   session2.php
   This page: 
     - demonstrates prsistence of a session variable
 -------------------------------------------------------------------->
<?php
if (!isset($_SESSION)) {
   session_start();
}
?>
<html>
  <head>
	 <title>Login</title>
   <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <center><h2>Login</h2></center>
  <form method="post">
   Username : <input type="text" name="uname"><br/>
   Password : <input type="text" name="password"><br/>
  <button type="submit">Login</button> <br/>
</form>


    <?php
    print'<form action="register.php" method="POST">';
    print'Dont have an account? Click here to <button type="submit">Register</button> <br/><br/></form>';

if (!function_exists('connectToDB'))   {
  function connectToDB($wdb_host,$wdb_user,$wdb_pass,$wdb_name): mysqli
    {
       $mysqli = new mysqli($wdb_host,$wdb_user,$wdb_pass,$wdb_name);
       if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }
       return $mysqli; 
    }
 }

 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
 $myfile = fopen('./auth/vals', "r") or die("Unable to open database settings file."); 
 $theParams=fread($myfile, filesize('./auth/vals'));
 fclose($myfile);
 $dbparams=explode(',',$theParams);

 $dbhandle = connectToDB($dbparams[0],$dbparams[1],$dbparams[2],$dbparams[3]); 

 
 if(isset($_POST['uname']) && isset($_POST['password'])) {

  function validate($data){

     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
  }

  $uname = validate($_POST['uname']);
  $pass = validate($_POST['password']);

 }


  if (isset($_POST['uname'])&&empty($uname)) {

    echo '<script type="text/javascript">';
    echo ' alert("No input for username, try again ")';  //not showing an alert box.
    echo '</script>';
      exit();

  }else if(isset($_POST['password'])&& empty($pass)){

    echo '<script type="text/javascript">';
    echo ' alert("No input for password, try again ")';  //not showing an alert box.
    echo '</script>';
     exit();

  }else{


  if((isset($_POST['uname'])&& !empty($uname))&&(isset($_POST['password'])&& !empty($pass))){


     $sql = "SELECT * FROM LoginDataTable WHERE username='$uname' AND password='$pass'";
     $result = mysqli_query($dbhandle, $sql);
 

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['username'] === $uname && $row['password'] === $pass) {

              print("Logged in!");

               
                exit();

            }else{
              echo '<script type="text/javascript">';
              echo ' alert("Wrong username or password, Try again")';  //not showing an alert box.
              echo '</script>';
              exit();
            }
            
       
          }else{
              echo '<script type="text/javascript">';
              echo ' alert("Wrong username or password, Try again")';  //not showing an alert box.
              echo '</script>';
              exit();
          }
    mysqli_close($dbhandle);
  }
}
   
  ?>
  </form>

  </body> 
</html>

  
