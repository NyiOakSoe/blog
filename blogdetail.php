<?php
    session_start();
    require 'config/config.php';
    require 'config/common.php';
    
    if(empty($_SESSION['user_id']) && empty($_SESSION['user_name'])){
      header('location:login.php');
    }
    $postId=$_GET['id'];
    $stmt=$pdo->prepare("SELECT * FROM posts WHERE id=$postId ");
    $stmt->execute();
    $result=$stmt->fetchAll();
    //echo "<pre>";
    // var_dump($result);
    

    //Show Comment
    $stmt_Show=$pdo->prepare("SELECT * FROM comments WHERE post_id=$postId");
    $stmt_Show->execute();
    $result_Show=$stmt_Show->fetchAll();
    
    
    
    //Show Comment
    $result_user=[];
    if($result_Show){
      foreach($result_Show as $key => $value){
        $user_id=$result_Show[$key]['user_id'];
    //Select users
    $stmt_user=$pdo->prepare("SELECT * FROM users WHERE id=$user_id ");
    $stmt_user->execute();
    $result_user[]=$stmt_user->fetchAll();
    
      }
      //var_dump($user_id);
    }
    //var_dump($result_user);
    
    
    
    //Select users
    

    //Insert Comment
    if($_POST){
      if(empty($_POST['comment'])){
        $commentError="! Need to fill Comment";
      }else{
      $comment=$_POST['comment'];
      $stmt=$pdo->prepare("INSERT INTO comments (user_id,post_id,content)VALUES (:user_id,:post_id,:content)");
      $result=$stmt->execute(
        array(
          ':user_id'=>$_SESSION['user_id'],
          ':post_id'=>$postId,
          ':content'=>$comment
        )
        );
        if($result){
          echo "<script>alert('Comment successful');window.location.href='blogdetail.php?id=$postId'</script>";
        }
    }
  }
    //Insert Comment


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important">
    

    <!-- Main content -->
    <section class="content">
    <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div style="text-align:center;float:none " class="card-title">
                    <h4><b><?php echo escape($result[0]['title'])?></b></h4>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <center><img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']?>" alt="Photo"></center>
                <br>
                <p style="width: 800px; margin:auto" ><?php echo escape($result[0]['content'])?></p></center>
                
                <div class="form-group" >
                  <a href="index.php" type="button" class="btn btn-warning">Back</a>
              </div>
              <h4>Comments</h4>
              </div>
              
              <!-- /.card-body -->
              <div class="card-footer card-comments" >
                
                <!-- /.card-comment -->
                <div class="card-comment">
                  <!-- User image -->
                  <?php
                  foreach($result_Show as $key=>$value){
                  ?>
                  <div class="comment-text" style="margin-left:0px !important">
                    <span class="username">
                      <?php echo escape($result_user[$key][0]['name']);?>
                      <span class="text-muted float-right"><?php echo escape($value['created_at']);?></span>
                    </span><!-- /.username -->
                    <?php echo escape($value['content']);?>
                  </div>
                  <?php
                  }
                  ?>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                    <p style="color:red"><?php echo !empty($commentError)?$commentError:''; ?></p>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
        <!-- /.row -->

        
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
