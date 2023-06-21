<?php
  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id'])){
    header('location:login.php');
  };
  $id=$_GET['id'];
  
    $stmt=$pdo->prepare("SELECT * FROM users WHERE id=$id");
    $stmt->execute();
    $result=$stmt->fetchAll();
    
  if(isset($_POST['addBTN'])){
    if(empty($_POST['name']) || empty($_POST['email']) ||  strlen($_POST['password'])<4){
        if(empty($_POST['name'])){
            $nameError="! Need to fill name";
        }
        if(empty($_POST['email'])){
            $emailError="! Need to fill Email";
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
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    
    $stmt->execute(
        array(
            ':email'=>$email,
            'id'=>$id
        )
    );
    $user_result=$stmt->fetch(PDO::FETCH_ASSOC);
    if($user_result){
        echo "<script>alert('Email already')</script>";
    }else{
         $stmt2=$pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id=$id");
         $update_result=$stmt2->execute();

         if($update_result){
        echo "<script>alert('Successfully Update');window.location.href='user.php'</script>";
            
         }
    }
    }   
}
    


   

//     if($result){
//         echo "<script>alert('New Account is Created')</script>";
//     }
    
//   }
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
                    <center><h4>Account Edit</h4></center>
                    </div>
                        <form  method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" id=""  value="<?php echo $result[0]['name'];?>">
                                <p style="color:red"><?php echo !empty($nameError)?$nameError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label><br>
                                <input type="email" name="email" class="form-control" id=""  value="<?php echo $result[0]['email'];?>">
                                <p style="color:red"><?php echo !empty($emailError)?$emailError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label><br>
                                <span style="font-size:12
                                
                                px">The user already has a password</span>
                                <input type="text" name="password" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($passwordNeed)?$passwordNeed:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="vehicle3">Admin</label><br>
                                <input type="checkbox" name="role" id="" value="1">
                                
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