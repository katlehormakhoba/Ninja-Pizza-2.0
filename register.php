<?php

include("connection/conn.php");

    $email = $cpwd = $pwd = $fname = $lname = $hashp = $phone_no = '';
    $errors = array('email'=>'', 'fname'=>'', 'lname'=>'', 'phone_no'=>'', 'pwd'=>'', 'cpwd'=>'');

    //VALIDATION FOR ENTERY
    if(isset($_POST['submit']))
    {
        //FIRST NAME VALIDATION 
        if (empty($_POST['fname']))
        {
            $errors['fname'] = 'Please enter your First Name';
        }
        else
        {
            $fname = $_POST['fname'];

            if(!preg_match('/^[a-zA-Z\s]+$/', $fname))
            {
                $errors['fname'] = 'First Name must not contain special characters';
            }
        }
        //LAST NAME VALIDATION
        if(empty($_POST['lname']))
        {
            $errors['lname'] = 'Please enter your Last Name';
        }
        else
        {
            $lname = $_POST['lname'];

            if(!preg_match('/^([a-zA-Z\s]+)(-\s*[a-zA-Z\s]*)*$/', $lname))
            {
                $errors['fname'] = 'Last Name contains invalid characters';
            }

        }

        //PHONE NUMBER VALIDATION
        if (empty($_POST['phone_no']))
        {
            $errors['phone_no'] = 'Please enter your phone number';
        }
        else
        {
            $phone_no = $_POST['phone_no'];

            if(strlen($phone_no) != 10)
            {
                $errors['phone_no'] ='Phone number must contain exactly 10 digits';
            }
        }
        //1ST PASSWORD VALIDATION
        if(empty($_POST['pwd']))
        {
            $errors['pwd'] = 'Please enter your password';
        }
        else
        {
            $pwd = $_POST['pwd'];

            if(strlen($pwd) < 7)
            {
                $errors['pwd'] ='Password  must have atleast 7 characters in lenght';
            }
        }
        //2ND PASSWORD VALIDATION
        if(empty($_POST['cpwd']))
        {
            $errors['cpwd'] = 'Please enter your password';
        }
        else
        {
            $cpwd = $_POST['cpwd'];
            $hashp= password_hash($pwd,PASSWORD_DEFAULT);

            if(!password_verify($pwd,$hashp))
            {
                $errors['cpwd'] ='Password do not match';
            }
        }
        //EMAIL VALIDATION 
        if(empty($_POST['email']))
        {
            $errors['email'] = 'PLease enter your Email Address';
        }
        else
        {
            $email = $_POST['email'];

            if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $errors['email'] = 'PLease enter Valid Email Address';
            }
            else
            {
                $query = "select * from users where email = '$email'";
                $result = mysqli_query($conn,$query);
                $rows = mysqli_num_rows($result);
                if(!mysqli_query($conn,$query))
                {
                    die("Database access failed: ". mysqli_connect_error());
                }

                if($rows > 0) // tests if number of rows returned are greater than 0
                {
                    $errors['email'] = 'Email Address already exists';
                } 

            }


           
        }


        if(array_filter($errors))
        {
            //Do not go through
        }
        else
        {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $fname = mysqli_real_escape_string($conn, $_POST['fname']);
            $lname = mysqli_real_escape_string($conn, $_POST['lname']);
            $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
            //$hashp = mysqli_real_escape_string($conn, $_POST['pwd']);

            $insert = "insert into users(email, fname, lname, phone_no, password, u_type) values('$email', '$fname', '$lname', '$phone_no','$hashp', 'user')";

            if(mysqli_query($conn,$insert))
            {
                header('Location: login.php');
            }
            else
            {
                echo 'Connection error: '. mysqli_connect_error();
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
            min-height: 1000px;
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
			position: absolute;
			margin-top: 2px;
			margin-left: -35px;
			margin-right: 15px;
            color:dodgerblue;
		}
        form
        {
            position: relative;
            margin-top: 75px;
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
<body class=" indigo lighten-3">
<!-------------------------------------------------- CREATION OF NAVBAR------------------------------------------START-->
<header>
<nav class="nav-wraper indigo">
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
<section class="container ">
    <h4 class="center "><b>Enter registration details</b></h4>
        <form class="hoverable transparent" action="register.php" method="POST">
           
           <span class="black-text darken-4" for="first_name"><i class="material-icons zz">account_box</i>First Name</span>
            <input placeholder="First name" type="text" name="fname" value="<?php echo htmlspecialchars($fname)?>" class="validate white-text">
            <div class="red-text"><?php echo $errors['fname']?></div>
           
            <!--<label for="last_name">Last Name</label>--->
            <span class="black-text darken-4" for="last_name">Last Name</span>
            <input placeholder="Last name" name="lname" type="text" value="<?php echo htmlspecialchars($lname)?>" class="validate">
            <div class="red-text"><?php echo $errors['lname']?></div>

            <span class="black-text darken-4" for="email"><i class="material-icons zz">email</i>Email</span> 
            <input placeholder="example@me.com" name="email" value="<?php echo htmlspecialchars($email)?>" type="email" class="validate">
            <div class="red-text"><?php echo $errors['email']?></div>
            
            <!--<label for="Phone_no">Phone number</label>-->
            <span class="black-text darken-4" for="Phone_no"><i class="material-icons zz">call</i>Phone number</span>
            <input placeholder="e.g 07653216778" name="phone_no" value="<?php echo htmlspecialchars($phone_no)?>" type="text" class="validate">
            <div class="red-text"><?php echo $errors['phone_no']?></div>

            <span class="black-text darken-4" for="password"><i class="material-icons zz">https</i>Password</span>              
            <input placeholder="Password" name="pwd" value="<?php echo htmlspecialchars($pwd)?>" type="password" class="validate">
            <div class="red-text"><?php echo $errors['pwd']?></div>

            <span class="black-text darken-4" for="c_password"><i class="material-icons zz">https</i>Confirm Password</span>              
            <input placeholder="Confirm password" name="cpwd" value="<?php echo htmlspecialchars($cpwd)?>" type="password" class="validate">
            <div class="red-text"><?php echo $errors['cpwd']?></div>
              
        <div class="container center">
			<input type="submit" name="submit" value="submit" class=" btn brand z-depth-0">
		</div>
    </form>
</section>

</header>

<!----------------------------------------------------END--------------REGISTRATION FORM-->



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