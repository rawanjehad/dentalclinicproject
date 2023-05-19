<?php
session_start(); // Starts a session to store user session data

$db=mysqli_connect('localhost','root','','dcms') or die("could not connect to database"); 
// //connect to the MySQL database ,local host since its on the same machine ,root is the user can access database,there is no password,dcms is the name of the database, it it fail by die the string :could not connect to database will be print

if(!isset($_SESSION['username']))
{
    // Checks if the session variable 'username' is not set or does not exist

    $_SESSION['redirect'] = 'clinics.php';
    // Stores the current page ('clinics.php') in the session variable 'redirect'

    header("location: login.php");
    // Redirects the user to the login.php page
}


if($_SESSION['role'] == 'dentist')
    header("location: index.php"); // If the user has the role 'dentist', they are redirected to the index.php page

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Clinics</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <link href="style10.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet"> 
    <style>
        /*    
        <tr> (Table Row): Represents a row in an HTML table.
        <td> (Table Data): Represents a cell within a table row. Each <td> element contains data or content for a specific column within the table.
        <th> (Table Header): Represents a header cell within a table row. It is typically used in the first row (<tr>) of a table to define column headings. */
        th, td { 
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: dodgerblue;
            color: white;
        }
        tr:hover {background-color: #ddd;}
        .nav__links{
            color:dodgerblue;
        }
        .nav__links:hover {color:darkblue;}   /* mouse over link (darkblue when mouse over)*/
        .nav__links:active {color:purple;}  /* selected link (purple in the split second which you loading the page.)*/

    </style>
</head>
<body>
    <center>
    <?php require_once("header.php");?> <!-- Includes the "header.php" file -->
    <div class="content-section" style="width:75%">
        <h2>Clinics</h2>

        <?php 
        $query = "SELECT * FROM clinic";
        $res = mysqli_query($db, $query); // Executes the SQL query to fetch clinic data from the database

        if(mysqli_num_rows($res) > 0) // Checks if there are any rows returned from the query
        {
            // If there are rows returned from the query, execute the following code block
        
            echo "<table><tr><th>ID</th><th>Clinic name</th><th>Opening Hour</th><th>Closing Hour</th><th></th></tr>";
            // Prints the table header row with column names: ID, Clinic name, Opening Hour, Closing Hour
        
            while($row = mysqli_fetch_assoc($res)) // Iterates through each row of the result set
            {
                // Assigns the values of each column in the current row to variables
                $id = $row['clinic_id'];
                $link = "dentists.php?location=".$id."";
                // Constructs a link to the dentists.php page with the clinic location (clinic_id) as a parameter
                $cl ="nav__links";
        
                echo "<tr><td>".$id."</td><td>".$row['location']."</td><td>".$row['open_hr']."</td><td>".$row['close_hr']."</td><td><a class='nav__links' href='".$link."' class='".$cl."'>Check Dentists</a></td></tr>";
                // Prints a table row with clinic information and a link to the dentists.php page for each row of the result set
            }
        }
        
        else
            echo "<h3>No clinics available</h3>"; // Displays a message if there are no clinics in the database

        ?>
        </table>
    </div>
    </center>
</body>
</html>
