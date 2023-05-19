<?php
session_start(); // Start the session
$db=mysqli_connect('localhost','root','','dcms') or die("could not connect to database"); //connect to the MySQL database ,local host since its on the same machine ,root is the user can access database,there is no password,dcms is the name of the database, it it fail by die the string :could not connect to database will be print

if(isset($_GET['logout'])){
    // Check if the 'logout' parameter is present in the URL query string
    
    session_destroy(); // Destroy the current session
    unset($_SESSION['username']); // Unset the 'username' session variable
    unset($_SESSION['role']); // Unset the 'role' session variable
    //unset($_COOKIE['remember']); // Unset the 'remember' cookie if used
    header("location: login.php"); // Redirect the user to the login.php page
}


?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css"> -->
    <style>
         body
         { overflow: hidden;} /* Hide scrollbars */

    </style>
</head>

<body>
    <?php require_once("header.php");?> <!-- Include the contents of the "header.php" file -->

    <div id="mobile__menu" class="overlay">
        <!-- The following HTML code represents a close button -->
        <a class="close">&times;</a>
        <div class="overlay__content">
            <a href="index.php">Home</a>
            <a href="registration.php">Sign up</a>
            <a href="login.php">Login</a>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------ -->
		<div class=homemain>
		<div class="caption">
		<?php if(isset($_SESSION['username'])):?>
	
    <h2>Welcome <strong><?php echo $_SESSION['username'] ; ?> </strong>
    </h2>
    <?php endif; ?>
	<br>
	<br>
	<br>
		<a class="w">We prioritise your</a>
		<h1>NEW SMILE</h1>
        <!-- <button class="ta" href="#">Read more</button> -->
		</div>
		</div>
		<?php if(isset($_SESSION['success'])):?>
        <div>
            <h3>
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success'])
            ?>
            </h3>
        </div>
    <?php endif;?>
    
		<div>
		<a class="main"><img src="images/main.jpg" alt="main"></a>
		</div>
        <script type="text/javascript" src="mobile.js"></script>  
</center>
</body>
</html>