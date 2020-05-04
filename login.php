<?php

include("connection/conn.php");
session_start();
$email = $pwd ='';
$Tpwd = false;
$errors = array('email'=>'', 'pwd'=>'');

if(isset($_POST['submit']))
{
	//EMIAL VARIFICATION
	if(empty($_POST['email']))
	{
		$errors['email'] = 'Please enter email address'; 
	}
	else
	{
		$email = $_POST['email'];

		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$errors['email'] = 'Please enter valid email address'; 
			$temail = false;
		}
		else
		{
			$query = "select * from users where email = '$email'";
			$result = mysqli_query($conn,$query);
			$rows = mysqli_num_rows($result);
			$temail = true;
			if(!mysqli_query($conn,$query))
			{
				die("Database access failed: ". mysqli_connect_error());
			}

			if($rows <= 0) // tests if number of rows returned are greater than 0
			{
				$errors['email'] = 'Email Address does not exists';
				$temail = false;
			} 
		}
	}

	if (empty($_POST["pwd"]))
	{
		$errors['pwd'] = "Password is required";
		$Tpwd=false;
	}
	else
	{

	    $pwd = $_POST["pwd"];
	    $Tpwd=true;
		   
	}
	
	if ($Tpwd)
	{
	   
		$query="select * from users where email = '$email'";;
		$result=mysqli_query($conn,$query);

		if(!$result)
		{
			die("Database access failed: ". mysqli_connect_error());
		}
		else
		{
			$rows=mysqli_num_rows($result);
			
			if($rows<1)
			{
				
			
			}
			else
			{
						
				while ($rows = mysqli_fetch_assoc($result)) 
				{
					$cpwd = $rows['password'];
					//!password_verify('$passwd',$cpwd) !hash_equals('$passwd',$cpwd)				

					if (!password_verify($pwd,$cpwd))
					{
						$errors['pwd'] ="incorrect password ";
					}
					else
					{
						$query = "select u_type 
						from users 
						where email = '$email'";
						$result = mysqli_query($conn,$query);
						$tpy = mysqli_fetch_all($result,MYSQLI_ASSOC);
						
						if($tpy[0]['u_type'] == 'admin')
						{
							$_SESSION['email']=$rows['email'];
							//echo '<script> window.location = "mindex.php";</script>';
							header('location:mindex.php');
						}
						else
						{
							$_SESSION['email']=$rows['email'];
							//echo '<script> window.location = "home.php";</script>';
							header('location:home.php');
						}
									
					}
												
				}
						
			}

		}
	}

}


?>


<!--START OF HTML PAGE-->

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
        header
        {
            background: url(img/home1.jpg);
            background-size: cover;
            background-position: center;
            min-height: 650px;
        }
            @media screen and (max-width: 670px)
            {
                header
                {
                    min-height: 500px;
                }
            }
   
		.kat
		{
			position: relative;
			left: 7px;	
		}
        .kat2
		{
			
			top: 200px;
		}
        .zz
		{
			position: relative;
			margin-top: 20px;
			margin-left: -35px;
			margin-right: 15px;
		}
        form
        {
            position: relative;
            margin-top: 45px;
        }
        .pizza
        {
            width: 100px;
            margin: 40px auto -30px;
            display: block;
            position: relative;
            top: -30px;

        }
        nav .badge
		{
			position: absolute;
			top: 35px;
			margin-left: -25px;
			margin-right: 15px;
			
		}
        body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }
	</style>
</head>
<body class=" indigo lighten-4">
<!-------------------------------------------------- CREATION OF NAVBAR------------------------------------------START-->
<header>
<nav class="nav-wraper indigo transparent">
    <div class="container">
        <a href="index.php" class="brand-logo">Ninja Pizza</a>
        <a href="" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Log in</a></li>
        </ul>
            <ul class="sidenav" id="mobile-links">
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Log in</a></li>
            </ul>
    </div>
</nav>

<!-------------------------------------------------- CREATION OF REGISTRATION FORM-----------START-->

<section class="container">
    <div class="container">
        <h4 class="center "><i class="material-icons large zz">account_box</i></h4>
        <h4 class="center ">Enter login details</h4>
    </div>
    <div class="container">
        <form class="transparent hoverable" action="login.php" method="POST">
            <span class="black-text darken-4" for="email"><i class="material-icons zz">email</i>Email</span>  
            <input placeholder="example@me.com" name="email" value="<?php echo htmlspecialchars($email)?>" type="email" class="validate">
            <div class="red-text"><?php echo $errors['email']?></div>

            <span class="black-text darken-4" for="password"><i class="material-icons zz">https</i>Password</span>             
            <input placeholder="Password" name="pwd" value="<?php echo htmlspecialchars($pwd)?>" type="password" class="validate">
            <div class="red-text"><?php echo $errors['pwd']?></div>
              
            <div >
			    <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
		    </div>
        </form>
    </div>

</section>





<!----------------------------------------------------END--------------REGISTRATION FORM-->

</header>

<!----------------------------------------------------END-------------------------------------------------------NAVBAR-->



  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
      $(document).ready(function()
      {
          $('.sidenav').sidenav();
      })

      $(".dropdown-trigger").dropdown()
  </script>

<?php include('templates/footer.php')?>
</body>
</html>