<?php
  session_start();
    require 'config/config.php';
    require 'config/common.php';

    
    if(isset($_POST['SignBTN'])){
      if(empty($_POST['email']) || empty($_POST['password'])){
        if(empty($_POST['email'])){
          $emailError="! Need to fill Email";
        }
        if(empty($_POST['password'])){
          $passwordError= "! Need to fill Password";
        }
      }else{
        $email=$_POST['email'];
        $password=$_POST['password'];
        $sql="SELECT * FROM users WHERE email=:email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':email',$email);
        $stmt->execute();
        $user=$stmt->fetch(PDO::FETCH_ASSOC);
        //print_r($user);
        if($user){
            if(password_verify($password,$user['password'])){
              if($user['role']==0){
                $_SESSION['user_id']=$user['id'];
                $_SESSION['user_name']=$user['name'];
                $_SESSION['logged_in']=time();
                $_SESSION['role']=$user['role'];
                header('location:index.php');
              }else{
                $_SESSION['user_id']=$user['id'];
                $_SESSION['user_name']=$user['name'];
                $_SESSION['logged_in']=time();
                $_SESSION['role']=$user['role'];
                header('location:admin/index.php');
              }
              
            
            }else{
              echo "<script>alert('Incorrect gmail or password')</script>";
            }
          }
      }
      
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Blog</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p style="color:red;"><?php echo empty($emailError)?'':$emailError; ?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <p style="color:red;"><?php echo empty($passwordError)?'':$passwordError; ?></p>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="SignBTN" class="btn btn-primary btn-block">Sign In</button>
            <a href="register.php" class="btn btn-default btn-block">Register</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
