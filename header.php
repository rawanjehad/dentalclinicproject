<header>
    <a class="logo" href="index.php"><img src="images/logo1.jpg" alt="logo"width=70px length=70px   style="border-radius: 5px;"></a>
    <nav>
    <ul class="nav__links">
    <li><a href="index.php">Home</a></li>
    <?php if(!isset($_SESSION['username'])){?> 
	 <li><a href="registration.php">Sign up</a></li>	
     <li><a class="cta" href="login.php">Login</a></li>
    <?php }?>
	<?php if(isset($_SESSION['username'])){
        if($_SESSION['role'] == 'admin')
        {
            echo "<li><a href='addclinic.php'>Add Clinic</a></li>";
            echo "<li><a href='adddentist.php'>Add Dentist</a></li>";
        }
        else {
        if($_SESSION['role'] == 'patient')
        {
            echo "<li><a href='clinics.php'>Choose Clinic </a></li>";
        }
    ?> 	
	 
    <li><a href="appointments.php">Appointments</a></li>
    <?php if($_SESSION['role'] == 'patient'){
    }}?> 
    
    <li><a href="index.php?logout='1'">Logout</a> </li>	
    <?php }?>
    

                   
                </ul>
            </nav>
           
            <p class="menu cta">Menu</p>

            
        </header>
  <br><br>