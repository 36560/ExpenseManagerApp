<div class="row">
  <div class="col ">    
  </div>
  
  <div class="col justify-content-center py-5 ">
    <div class="jumbotron bg-dark text-light">
    <div class="container text-center">
    <i class="fas fa-door-open"></i>
    <h3>Log in</h3> 
    <?php    
      if(isset($_SESSION["error"]))
      {
        $err = $_SESSION["error"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Error! </strong>'.$err.'</div>';
              
        unset($_SESSION['error']);
      }      
    ?>
      <form method="POST" class="form-group">        
        <label>Login</label> <br/>
        <input type="text" name="username" class="form-control" required/> 
        <br/>
        <label>Password</label> <br/>
        <input type="password" name="pass" class="form-control" />
        <br/>
        <input type="submit" name="login" value="Zaloguj" class="btn btn-block  btn-danger"/>
      </form>
  </div>
</div>
</div>
  <div class="col">    
  </div>
</div>
