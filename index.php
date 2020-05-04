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
<!-------------------------------------------------- CREATION OF NAVBAR-------------------------------------->
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



</header>

<!----------------------------------------------------END---------------------------------------------------------->



<!-------------------------------------------------- CREATION OF Cards-------------------------------------------->

<!----------------------------------------------------END---------------------------------------------------------->


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