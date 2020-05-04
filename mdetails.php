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

if(isset($_POST['delete']))
{
	$id_del = mysqli_real_escape_string($conn, $_POST['id_delete']);

	$query = "delete from pizzas where pzza_id = $id_del";

	$del_result = mysqli_query($conn, $query);

	if($del_result)
	{
		header('Location: index.php');
	}
	else
	{
		echo "connection error: " . mysqli_error($conn);
	}
}

if(isset($_GET['p_id']))
{
	$id = mysqli_real_escape_string($conn, $_GET['p_id']);

	$query = "select * from pizza where p_id = $id";

	$result = mysqli_query($conn, $query);

	$pizza = mysqli_fetch_assoc($result);

}

//CART INCREMENT-----------------------------------------------------------------------------------------START

// MY QUERY
$query_c ="select count(*) as b from cart where u_id = '$u_id' and status = 'pending'";
//MAKE QUERY
$result_c = mysqli_query($conn, $query_c);
//FETCH QUERY
$bougth = mysqli_fetch_all($result_c,MYSQLI_ASSOC);  //variable $pizzas is now a array


//------------------------------------------------------------------------------------------END


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
		div .pull
		{
			margin-top: -20px;
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

<h2 class="center indigo-text text-darken-4">Pizza Details</h2>

<section class="container section" id="photos">
    <div class="row">
    <a href="medit.php?p_id=<?php echo $pizza['p_id']; ?>" class="tooltipped btn-floating pink pulse " data-tooltip="Edit Pizza"> <!--TO MAKE FAVORATE BUTTON-->
        <i class="material-icons kat">edit</i>
</a>
      <div class="col s12 l4">
      <?php if($pizza): ?>
          <img src="<?php echo htmlspecialchars($pizza['url']); ?>" alt="" class="responsive-img materialboxed">

      </div>
      <div class="col s12 l6 offset-l1">
        <h5 class="indigo-text text-darken-4"><?php echo htmlspecialchars($pizza['title']); ?></h5>
		<p>Created by: <?php echo htmlspecialchars($pizza['creater']); ?></br>Created at: <?php echo htmlspecialchars($pizza['created_at']); ?></p>
		<h5 class="indigo-text text-darken-4">Ingredients</h5>
		<p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>
		<?php else: ?>
			<h1 class="center">Pizza Does Not Exist</h1>
	<?php endif; ?>
      </div>
    </div>

  </section>

  <div class="container pull">
  <h5 class="indigo-text text-darken-4 pull">About :</h5>
  <p>A doctor is experiencing a lot of patients during his daily basis at his local pharmacy, 
  almost every day there’s a long queue to consult and some patients return home without being assisted. 
  Looking at our economy, money and time are one of the things that should be managed very well. </p>

  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){

      $('.sidenav').sidenav();
      $('.materialboxed').materialbox();
      $(".dropdown-trigger").dropdown();
      $('.tooltipped').tooltip();

    });
  </script>

<?php include('templates/footer.php')?>
</html>