<?php
    
    session_start();
    require 'config/config.php';
    require 'config/common.php';
    if(isset($_POST['SignBTN'])){
      if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) ){
        if(empty($_POST['name'])){
            $nameError="! Need to fill name";
        }
        if(empty($_POST['email'])){
            $emailError="! Need to fill Email";
        }
        if(empty($_POST['password'])){
            $passwordError="! Need to fill Password";
        }
        
      }elseif(strlen($_POST['password'])<4){
        
          $passwordNeed="! 4 characters Need to Fill in password";
      }else{
        $name=escape($_POST['name']);
      $email=escape($_POST['email']);
      $password=escape(password_hash($_POST['password'],PASSWORD_DEFAULT));


      $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_ASSOC);

      if($result['email']==$email){
        echo "<script>alert('Your email is already!!')</script>";
      }else{
        $stmt=$pdo->prepare("INSERT INTO users(name,email,password) VALUES(:name,:email,:password)");
        $result=$stmt->execute(
          array(
            ':name'=>$name,
            ':email'=>$email,
            ':password'=>$password
          )
          );

        if($result){
          echo "<script>alert('Register successful!!');window.location.href='login.php'</script>";

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
  <title>Blog | Register</title>

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
    <a href="#"><b>Blog</b>Register</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New Account</p>

      <form action="" method="post">
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
      <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p style="color:red"><?php echo !empty($nameError)?$nameError:'';?></p>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p style="color:red"><?php echo !empty($emailError)?$emailError:'';?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <p style="color:red"><?php echo !empty($passwordError)?$passwordError:'';?></p>
        <p style="color:red"><?php echo !empty($passwordNeed)?$passwordNeed:'';?></p>

        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="SignBTN" class="btn btn-primary btn-block">Register</button>
            <a href="login.php" class="btn btn-default btn-block">login</a>
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
