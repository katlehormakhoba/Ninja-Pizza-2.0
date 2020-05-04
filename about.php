<?php
// call this session.php ------------------------------------------------------------------------------START
include("connection/conn.php");
  session_start();

  if(isset($_SESSION['email']))
{
    $user = $_SESSION['email'];
    //echo $user;   WAS TESTING IF USER IS CORRECTLY LOGED IN

    $u_query = "select * from users where email = '$user'";
    $u_result = mysqli_query($conn, $u_query);

    $u_rows=mysqli_num_rows($u_result);
    while ($u_rows=mysqli_fetch_array($u_result)) 
    {
   
       $u_id = $_SESSION['u_id']= $u_rows['u_id']; 
       $u_name = $_SESSION['fname']= $u_rows['fname'];  
       $u_surname = $_SESSION['lname']= $u_rows['lname'];
       //$dob = $_SESSION['dob']= $rows['dob']; 
       $cellno = $_SESSION['phone_no']=$u_rows['phone_no'];
       
    
    }
                   


}
//END--------------------------------------------------------------------------------------------------END

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
     <!-- Compiled and minified CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <title>Ninja pizza</title>
	<style>
    header{
      background: url(img/1.jpg);
      background-size: cover;
      background-position: center;
      min-height: 1000px;
    }
    @media screen and (max-width: 670px){
      header{
        min-height: 500px;
      }
    }
    .section{
      padding-top: 4vw;
      padding-bottom: 4vw;
    }
	</style>
</head>
<body class=" indigo lighten-4">
<!-------------------------------------------------- CREATION OF NAVBAR-------------------------------------->

<nav class="nav-wraper indigo ">
    <div class="container">
        <a href="home.php" class="brand-logo">Ninja Pizza</a>
        <a href="" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a href="home.php">home</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
            <ul class="sidenav" id="mobile-links">
                <li><a href="home.php">home</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
    </div>
</nav>



<h1 class="center indigo-text">About Ninja Pizza</h1>
<div class="container">

    <p>Foods similar to pizza have been made since the Neolithic Age.[18] Records of people adding other ingredients to 
    bread to make it more flavorful can be found throughout ancient history. In the 6th century BC, the Persian soldiers 
    of Achaemenid Empire during the rule King Darius I baked flatbreads with cheese and dates on top of their battle 
    shields[19][20] and the ancient Greeks supplemented their bread with oils, herbs, and cheese.[21][22] An early 
    reference to a pizza-like food occurs in the Aeneid, when Celaeno, queen of the Harpies, foretells that the Trojans 
    would not find peace until they are forced by hunger to eat their tables (Book III). In Book VII, Aeneas and his men 
    are served a meal that includes round cakes (like pita bread) topped with cooked vegetables.
     When they eat the bread, they realize that these are the "tables" prophesied by Celaeno.</p>
   </div>

  <div class="parallax-container">
    <div class="parallax">
      <img src="img/unnamed.jpg" alt="" class="responsive-img">
    </div>
  </div>
  <div class="container">

<p>Foods similar to pizza have been made since the Neolithic Age.[18] Records of people adding other ingredients to 
bread to make it more flavorful can be found throughout ancient history. In the 6th century BC, the Persian soldiers 
of Achaemenid Empire during the rule King Darius I baked flatbreads with cheese and dates on top of their battle 
shields[19][20] and the ancient Greeks supplemented their bread with oils, herbs, and cheese.[21][22] An early 
reference to a pizza-like food occurs in the Aeneid, when Celaeno, queen of the Harpies, foretells that the Trojans 
would not find peace until they are forced by hunger to eat their tables (Book III). In Book VII, Aeneas and his men 
are served a meal that includes round cakes (like pita bread) topped with cooked vegetables.
 When they eat the bread, they realize that these are the "tables" prophesied by Celaeno.</p>
</div>

  <!-- Compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){

      $('.sidenav').sidenav();
      $('.materialboxed').materialbox();
      $('.parallax').parallax();
    });
  </script>
  <?php include('templates/footer.php')?>
</body>
</html>