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



$name = $title = $price = $url = $ingredients = $p_id ='';
$errors = array('name' =>'' ,'price' =>'' ,'url' =>'', 'title' =>'' , 'ingredients' =>'');
if(isset($_POST['submit']))
{

//VALIDATION FOR ENTERY
	if(empty($_POST['name']))
	{
		$errors['name'] = 'Name is required';
	}
	else
	{
			$name = $_POST['name'];

            if(!preg_match('/^[a-zA-Z\s]+$/', $name))
            {
                $errors['name'] = 'Name must not contain special characters';
            }
	}
	if(empty($_POST['url']))
    {
        $errors['url'] = 'URL is required';
    }
    else
    {
        $url = $_POST['url'];

        if(!filter_var('http://www.example.com' . $url, FILTER_VALIDATE_URL))
        {
            $errors['url'] = 'Invalid URL';
        }

    }

	if(empty($_POST['title']))
	{
		$errors['title'] = 'Title is required';
	}
	else
	{
			$title = $_POST['title'];

			if(!preg_match('/^[a-zA-Z\s]+$/', $title))
			{
				$errors['title'] = 'Title must not contain special charactors';
			}
	}

	if(empty($_POST['ingredients']))
	{
		$errors['ingredients'] = 'Ingredients is required';
	}
	else
	{
			$ingredients = $_POST['ingredients'];

			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients))
			{
				$errors['ingredients'] = 'Ingredients must be separated by comma ","';
			}
	}

	if (empty($_POST['price']))
	{
		$errors['price'] = 'Please Enter Pizza Price';
	}
	else
	{
		$price = $_POST['price'];

		//if((!preg_match('/^[a-zA-Z\s]+$/', $price)))
		//{
			//$errors['price'] ='Phone number must contain exactly 10 digits';
		//}
	}

	if(array_filter($errors))
	{

	} 
	else
	{
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$price = mysqli_real_escape_string($conn, $_POST['price']);
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
		$url = mysqli_real_escape_string($conn, $_POST['url']);

		// MY QUERY
		$insert = "insert into pizza(title, creater, ingredients, price, url) values('$title', '$name', '$ingredients', '$price', '$url')";

		//save to db
		if(mysqli_query($conn, $insert))
		{
			//IF SUCCESSFULLY SAVE THEN REDIRECT TO HOME PAGE
			header('Location: mindex.php');

		}
		else
		{
			//ECHO ERROR MESSAGE;
			echo 'connection error ' . mysqli_connect_error();
		}
	}




		
}

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
        header
        {
            background: url(img/man.jpg);
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
        .zz
		{
			position: absolute;
			top: 5px;
			margin-left: -35px;
			margin-right: 15px;
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
	</style>
</head>
<body class=" indigo lighten-4">
<!-------------------------------------------------- CREATION OF NAVBAR-------------------------------------->
<nav class="nav-wraper indigo">
    <div class="container">
        <a href="mindex.php" class="brand-logo">Ninja Pizza</a>
        <a href="" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a class="dropdown-trigger" data-target="dropdown1"><i class="material-icons zz">account_box</i><?php echo $u_name;?><i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a href="mindex.php">home</a></li>
            <li><a href="madd.php">Add Pizza</a></li>
            <li><a href="mpay.php">Orders</a></li>
        </ul>
            <ul class="sidenav" id="mobile-links">
                
                <li><a href=""><?php echo $u_name;?></a></li>
                <li><a href="mindex.php">home</a></li>
                <li><a href="madd.php">Add Pizza</a></li>
                <li><a href="mpay.php">Orders</a></li>
            </ul>
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="">Favourites</a></li>
                <li><a href="<?php echo "logout.php";?>">Log out</a></li>
            </ul>
    </div>
</nav>

<!----------------------------------------------------END---------------------------------------------------------->

<section class="container ">
	<h4 class="center">Add Pizza</h4>
	<form class="white transparent" action="madd.php" method="POST">
		<label>Enter Your Name</label>
		<input type="text" name="name" value="<?php echo htmlspecialchars($name)?>">
		<div class="red-text"><?php echo $errors['name']?></div>
		<label>Enter Pizza Title</label>
		<input type="text" name="title" value="<?php echo htmlspecialchars($title)?>">
		<div class="red-text"><?php echo $errors['title']?></div>
		<label>Enter Pizza URL</label>
		<input type="text" name="url" value="<?php echo htmlspecialchars($url)?>">
		<div class="red-text"><?php echo $errors['url']?></div>
		<label>Enter Ingredients</label>
		<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients)?>">
		<div class="red-text"><?php echo $errors['ingredients']?></div>
		<label>Enter Price</label>
		<input type="text" name="price" value="<?php echo htmlspecialchars($price)?>">
		<div class="red-text"><?php echo $errors['price']?></div>
		<div >
			<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
		</div>
	</form>
</section>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function()
        {
            $('.sidenav').sidenav();
            $(".dropdown-trigger").dropdown();
        });   
            
    </script>
<?php include('templates/footer.php')?>
</body>
</html>