<?php  
session_start(); //start a new or resume existing session
if(isset($_SESSION['username'])) //if session username exists, redirect to index.php
header('location:index.php');


$username=""; //initialize the $username variable
$email=""; //initialize the $email variable
$errors=[]; //initialize the $errors array
$db=mysqli_connect('localhost','root','','dcms') or die("could not connect to database"); 
//connect to the MySQL database ,local host since its on the same machine ,root is the user can access database,there is no password,dcms is the name of the database, it it fail by die the string :could not connect to database will be print

if(isset($_POST['reg_user'])) //if the registration form is submitted 
//,reg_user the name of the button,POST is  variable that holds data submitted through the HTTP POST method. When the form is submitted, all the form data is sent to the server using the POST method
{
  $username= mysqli_real_escape_string($db, $_POST['username']); //get the entered username and escape special characters to prevent SQL injection, the first parameter is the connection to the database (in this case $db), and the second parameter is the string to be escaped (in this case $_POST['username'].

  $email= mysqli_real_escape_string($db, $_POST['email']); //get the entered email and escape special characters to prevent SQL injection
  $password_1= mysqli_real_escape_string($db, $_POST['password_1']); //get the entered password and escape special characters to prevent SQL injection
  $password_2= mysqli_real_escape_string($db, $_POST['password_2']); //get the re-entered password and escape special characters to prevent SQL injection
  $role = mysqli_real_escape_string($db, $_POST['role']); //get the selected user role and escape special characters to prevent SQL injection,role" refers to the type of user that is being registered

  //regex validation 
  $uppercase = preg_match('@[A-Z]@', $password_1);//check if the password contains uppercase letters,match return boolean value stored in uppercase if there is a uppercase then true else false 
  $lowercase = preg_match('@[a-z]@', $password_1); //check if the password contains lowercase letters
  $number = preg_match('@[0-9]@', $password_1); //check if the password contains numbers
  $specialChars = preg_match('@[^\w]@', $password_1); //check if the password contains special characters ,^\w matches any non-word character

  if($password_1 !=$password_2) { //if the entered passwords don't match, add an error message to the $errors array and that by array_push
    array_push($errors, "Passwords do not match");
  }
  else if(!$uppercase || !$lowercase || !$number || !$specialChars) { //if the password does not meet the regex validation, add an error message to the $errors array

    array_push($errors, "Password must contain at least one lowercase, one uppercase, one digit and one special character.");
  }
  else
  {
    $user_check_query= " SELECT * FROM user WHERE username='$username' or email='$email' LIMIT 1"; 
    //check if the entered username or email already exists in the user table in database,       cheak if entered username or email matches a username or email in the user table.
    //LIMIT 1: This limits the number of rows returned by the query to one. Since usernames and emails should be unique, we don't need to check for more than one match.
    
    $results= mysqli_query($db, $user_check_query); //execute the query user_check_query using the function mysqli_query which take database connection(db)and the name of quary(user_check_query)

    $user = mysqli_fetch_assoc($results); //fetch the query result as an associative array ,, the fetched array contains the details of the user that matches the entered username or email. If there is no match, the $user variable will be set to NULL.

    if($user) //if the username or email already exists, add an error message to the $errors array( if the user is not null)
    {
      if($user['username'] == $username) { // the record match the username that entered then the username is already exists so an error message will be added to errors array using array_push
          array_push($errors, "Username already exists");
        }
      if($user['email'] == $email) { // ifthe record match the email that entered then the email is already exists so an error message will be added to errors array using array_push
          array_push($errors, "User with this email ID already exists");
        }
    }
    else{//(if the user=null)if the username and email don't exist,create a new user in the database

      $password= hash('sha256',$password_1); //hash the password using SHA256 algorithm,using hash() function, which takes the entered password and encrypts it using the SHA256 algorithm, to securely store the password in the database.

        $query = "INSERT INTO user (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";//create an SQL query using insert into that inserts the user's information (username, email, hashed password, and role) into the user table in the database.

        mysqli_query($db, $query); // execute the query to insert new user into database
        header('location: login.php'); // redirect to login page after user is created
      }
      

          }
        }
      
    ?>  

<!DOCTYPE html>
<head>
  <title>Registration</title>
  <link rel="stylesheet" href="css1/style1.css">
   <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="dental clinic">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="material-design-iconic-font/css/material-design-iconic-font.min.css">   <!-- this library for icon -->
        
</head>
<body>

  <!--  including the content of the "header.php" file into the current file. The "header.php" file  that needs to be included on multiple pages of the website. By using the "require_once" function, the code is ensuring that the "header.php" file is only included once to prevent any errors or duplicate content.-->

  <?php require_once("header.php");?>

  <!-- Create a signup form section -->
  <section class="signup">
      <!-- Create a container for the form -->
      <div class="container">
          <!-- Create a container for the signup content -->
          <div class="signup-content">
              <!-- Create a container for the signup form -->
              <div class="signup-form">
                  <!-- Create a title for the form -->
                  <h2 style='color:rgba(0, 136, 169, 1)'; class="form-title">Sign up</h2>
                  <?php
                      // Check if there are any errors in the $errors array
                      if(sizeof($errors)>0) //if true then there is an error
                      {
                        // Loop through each error in array errors and display it in a red font
                        foreach($errors as $err)
                        {
                        echo "<h3 style='color:red; width:75%'>".$err."</h3><br>"; // error stored in err then display by echo in red,br line between error
                        }
                      }
                  ?>

                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <!-- The for attribute of the <label> element specifies which form element it is associated with, by matching the id attribute of the associated form element. When the label is clicked, it will focus on the associated form element or activate it -->

                                <input type="text" name="username" minlength="2" maxlength="32" id="name" placeholder="Enter username" required />
                                <!-- name="username" specifies the name of the input field which will be  used to identify the input in the backend code.
                                * minlength="2" specifies the minimum length of the text that can be entered in the input field.
                                * maxlength="32" specifies the maximum length of the text that can be entered in the input field -->
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
								
                                <input type="email" name="email"  maxlength="50" id="email" placeholder="Your Email" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password_1" id="pass" placeholder="Password" minlength="8" maxlength="32" required />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_2" id="re_pass" placeholder="Repeat your password" minlength="8" maxlength="32" required />
                            </div>
                           <div class="form-group">
                            <label style="font-size:18px; color:rgba(0, 136, 169, 1);">Select the type of user</label><br></div>
                            <!-- label for a group of radio buttons that allows users to select the type of user -->
                            <div class="form-group">
                            <p style="color:white">Dentist</p>
                            <input type="radio" name="role" id="dentist" value="dentist" required style="width:60%">
                            <!-- if this radio button is selected, the value "dentist" will be sent to the server when the form is submitted.  -->
                            <label for="dentist" style="font-weight:normal; font-size:16px">Dentist</label><br>
                            </div>
                            <div class="form-group">
                            <p style="color:white">Patient</p>
                            <input type="radio" name="role" id="patient" value="patient" required style="width:60%">
                            <label for="patient" style="font-weight:normal; font-size:16px">Patient</label><br>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="reg_user" id="signup" class="example_e" value="Create Account"/></div>
                          </form>
                    </div>
                    <div class="signup-image">
                        <img src="images/signup-image.PNG" alt="sign up image" >
                        <a href="login.php" class="signup-image-link" style="color:rgba(0, 136, 169, 1)">Already a member? Log in</a>
                    </div>
                </div>
            </div>
        </section>


    </div>


</body>
</html>