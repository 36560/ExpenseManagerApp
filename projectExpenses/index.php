<?php    
    include('basecon.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

<body>

    <?php include('navbar.php'); ?>

     <div style="background: url(https://images.pexels.com/photos/4386341/pexels-photo-4386341.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940)" class="page-holder bg-cover">
     <?php
        if(isset($_GET['action']))
        {
          $action = $_GET['action'];

          if($action == 'login')
          {
            include('login.php');
          }
          if($action == 'register')
          {
            include('register.php');
          }
        }
        else
        {
          include('register.php');
        }    
    ?>
    </div>

</body>
</html>

