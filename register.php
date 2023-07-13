<?php
if (!isset($_SESSION)) {
   session_start();
}
?>

<html>
  <head>
	 <title>Register</title>
   <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <center><h2>Register</h2></center>
  <form method="post">
   First name : <input type="text" name="first_name"><br/>
   Last name : <input type="text" name="last_name"><br/>
   Username : <input type="text" name="uname"><br/>
   Password : <input type="text" name="password"><br/>
  <button type="submit">Create Account</button> <br/>
  

</form>


<?php

class newUser{
    public $user_name;
    public $pass_word;
    public $firstName;
    public $lastName;
}

print'<form action="formTest.php" method="POST">';
print'<button type="submit">Go back to Login</button> <br/><br/></form>';

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


if(isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {


function validate($data){

 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;

}

$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);
$firstName = validate($_POST['first_name']);
$lastName = validate($_POST['last_name']);

}


if (isset($_POST['uname']) && empty($uname)) {

    echo '<script type="text/javascript">';
    echo ' alert("No Username entered, Try again")';  //not showing an alert box.
    echo '</script>';
    exit();
 

}else if(isset($_POST['password']) && empty($pass)){

    echo '<script type="text/javascript">';
    echo ' alert("No Password entered, Try again")';  //not showing an alert box.
    echo '</script>';
    exit();


}else if(isset($_POST['first_name']) && empty($firstName)){
    echo '<script type="text/javascript">';
    echo ' alert("No First name entered, Try again")';  //not showing an alert box.
    echo '</script>';
    exit();

}else if(isset($_POST['last_name']) && empty($lastName)){
    echo '<script type="text/javascript">';
    echo ' alert("No Last name entered, Try again")';  //not showing an alert box.
    echo '</script>';
    exit();

}else{

    if((isset($_POST['uname'])&& !empty($uname))&&(isset($_POST['password'])&& !empty($pass))){

 $sql = "SELECT * FROM LoginDataTable WHERE username='$uname' AND password='$pass'";
 $result = mysqli_query($dbhandle, $sql);


    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        if ($row['username'] === $uname){
            echo '<script type="text/javascript">';
            echo ' alert("Username taken, Try again")';  //not showing an alert box.
            echo '</script>';
            exit();
        }
        
        if ($row['password'] === $pass) {

            echo '<script type="text/javascript">';
            echo ' alert("Password taken, Try again")';  //not showing an alert box.
            echo '</script>';
    exit();
        }



    }else{

        $userObject = new newUser();
        $userObject->user_name = $uname;
        $userObject->pass_word = $pass;
        $userObject->firstName = $firstName;
        $userObject->lastName = $lastName;
       
        $sql = "INSERT INTO LoginDataTable (username,password,first, last, street, city,state,zip,age,salary)VALUES('$uname', '$pass', '$firstName','$lastName','N/A','N/A','N/A','N/A','N/A','N/A')";

        if ($dbhandle->query($sql) === TRUE) {
            echo '<script type="text/javascript">';
            echo ' alert("Account successfully created! User is now able to login")';  //not showing an alert box.
            echo '</script>';
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $dbhandle->error;
        }   


         exit();
        
        }
        
      
mysqli_close($dbhandle);
    }
}

?>
</form>

</body> 
</html>


