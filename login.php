<?php
// include databased configuration file .It usually contains  the connection to the MYSQL database
include 'config.php';
session_start();
//Starts  a new session 
//session are used to store user dta (like login info across pages.)

if(isset($_POST['submit'])){
// this checks if the form was submittes (typically using a POST method with a submit button).
$email = mysqli_real_escape_string($conn, $_POST['email']);
//is used to prevent SQL injection by escaping special characters.
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   //md5  hash the password for basic security, extra safety


   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
// Queries  the database to find a match for the provided email and hashed password .if query fails it shoes query failed.
   if(mysqli_num_rows($select) > 0){
      //if the query returns one or more rows the login is valid.
      $row = mysqli_fetch_assoc($select);
      //fetch user details.
      $_SESSION['user_id'] = $row['id'];
      //set session variable  user_id
      header('location:index.php');
      // redirect the user to index.php
   }else{
      $message[] = 'incorrect password or email!';
      // if no match or not found  it stores an error message.
   }

}

?>

<!---->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   //this cecks if there is any message to show 
   // wrong password 
   foreach($message as $message){
      //loops through all message if you have 2 message  it will show both
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
      //onclick  when you click the message it ddisappears. 
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter email" class="box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <input type="submit" name="submit" class="btn" value="login now">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</div>

</body>
</html>