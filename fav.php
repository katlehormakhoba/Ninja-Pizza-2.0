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
//END--------------------------------------------------------------------------------END


//---------------------------------------------------------------------------------------------------START
if(isset($_GET['fav']))
{
    $fav = $_GET['fav'];

    $query_check = "select * from favourites where p_id = '$fav' and u_id = '$u_id'";
    $result_check = mysqli_query($conn,$query_check);
    $rows = mysqli_num_rows($result_check);
    
    if($rows > 0)
    {
        $query_d = "delete from favourites where p_id = '$fav' and u_id = '$u_id')";
        $result_d = mysqli_query($conn,$query_d);

        header('Location:home.php');        
    }
    else
    {
        $query = "insert into favourites(p_id, u_id) values('$fav', '$u_id')";
        $result = mysqli_query($conn,$query);

        header('Location:home.php');
    }

}
//-------------------------------------------------------------------------------END



// DISPAYING PIZZAS ON HOME------------------------------------------------------------------------------START
// MY QUERY
$query = "select pizza.p_id, pizza.title, pizza.ingredients, pizza.price from pizza, favourites
where favourites.u_id = '$u_id'
and pizza.p_id = favourites.p_id order by favourites.created_at ";
//MAKE QUERY
$result = mysqli_query($conn, $query);
//FETCH QUERY
$lists = mysqli_fetch_all($result,MYSQLI_ASSOC);  //variable $pizzas is now a array
//echo $pizzas[1]['title'];

//------------------------------------------------------------------------------------END

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
        <a href="home.php" class="brand-logo">Ninja Pizza</a>
        <a href="" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
            <li><a class="dropdown-trigger" data-target="dropdown1"><i class="material-icons zz">account_box</i><?php echo $u_name;?><i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a href="home.php">home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="history.php">History</a></li>
            <li><a href="cart.php?cartu_id=<?php echo $u_id?>" class="btn-floating indigo z-depth-0">
                <i class="material-icons hoverable pink darken-3">add_shopping_cart</i>
            </li></a>
            <li><span class="badge indigo white-text"><?php echo $bougth[0]['b']?></span></li>
        </ul>
            <ul class="sidenav" id="mobile-links">
                
                <li><a href=""><?php echo $u_name;?></a></li>
                <li><a href="home.php">home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="history.php">History</a></li>
            </ul>
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="fav.php">Favourites</a></li>
                <li><a href="<?php echo "logout.php";?>">Log out</a></li>
            </ul>
    </div>
</nav>

<!----------------------------------------------------END---------------------------------------------------------->

<h4 class="center grey-text">Your Favorate Pizzas</h4>


<div class="container">
<table>
        <thead>
          <tr>
              <th>Title</th>
              <th>Ingredients</th>
              <th>Price "each"</th>
              <th></th>
          </tr>
        </thead>

        <tbody>
        <?php foreach($lists as $list) : ?>
          <tr>
            <td><?php echo htmlspecialchars($list['title']); ?></td>
            <td><?php echo htmlspecialchars($list['ingredients']); ?></td>
            <td><?php echo htmlspecialchars($list['price']); ?></td>
            <td><a href="details.php?p_id=<?php echo $list['p_id']?>" class="btn right">More Info</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
</div>



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
</html>