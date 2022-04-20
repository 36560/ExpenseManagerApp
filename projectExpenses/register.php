 <div class="row">
  <div class="col">    
  </div>

  <div class="col justify-content-center py-5">
  <div class="jumbotron bg-dark text-light">
    <div class="container text-center">

    <?php    
      if(isset($_SESSION["success"]))
      {
        $success = $_SESSION["success"];
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Welcome! </strong>'.$success.'</div>';              
        unset($_SESSION['success']);
      }
      if(isset($_SESSION["error"]))
      {
        $err = $_SESSION["error"];
        echo  '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Error! </strong>'.$err.'</div>';
        unset($_SESSION['error']);
      }      
    ?>    
      <i class="fas fa-registered"></i>
      <form method="POST" class="form-group">
      <h3>Register</h3> 
        <label>Login</label> <br/>
          <input type="text" name="username" class="form-control" required/> 
          <br/>
          <label>Password</label> <br/>
          <input type="password" name="pass" class="form-control" required/>
          <br/>
          <input type="submit" name="register" value="Zarejestruj" class="btn btn-block btn-info"/>
      </form>
    </div>
    </div>
  </div>
<div class="col">    
  </div>
</div>
