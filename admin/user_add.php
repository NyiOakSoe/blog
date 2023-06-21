<?php
  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id'])){
    header('location:login.php');
  };
  
  if(isset($_POST['addBTN'])){
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<4){
        if(empty($_POST['name'])){
            $nameError="! Need to fill name";
        }
        if(empty($_POST['email'])){
            $emailError="! Need to fill Email";
        }
        if(empty($_POST['password'])){
            $passwordError="! Need to fill Password";
        }
        if(strlen($_POST['password'])<4){
            $passwordNeed="! 4 characters Need to Fill in password";
        }

    }else{
        $name=$_POST['name'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    
    if(!empty($_POST['role'])){
        $role=1;
    }else{
        $role=0;
    }


    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user){
        echo "<script>alert('Email is already');</script>";
    }else{
        $stmt=$pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
        $result=$stmt->execute(
        array(
            ':name'=>$name,
            ':email'=>$email,
            ':password'=>$password, 
            'role'=>$role    
        )
    );
    if($result){
        echo "<script>alert('New Account is Created')</script>";
    }
    }
    }
    

    
    
  }
?>
<?php
  include ('header.html');
?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="margin:auto !important">
                <div class="card"   >
                    
                    <div class="card-body">
                    <div>
                    <center><h4>New Account</h4></center>
                    </div>
                        <form  method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($nameError)?$nameError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label><br>
                                <input type="email" name="email" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($emailError)?$emailError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label><br>
                                <input type="password" name="password" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($passwordError)?$passwordError:'';?></p>
                                <p style="color:red"><?php echo !empty($passwordNeed)?$passwordNeed:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Admin</label><br>
                                <input type="checkbox" name="role" id="">
                                
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit" name="addBTN" class="btn btn-success">
                                <a href="user.php" type="button" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  <?php
    include ('footer.html');
  ?>