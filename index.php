<?php
  
  session_start();
  require 'config/config.php';
  require 'config/common.php';
  
  if(empty($_SESSION['user_name']) && empty($_SESSION['user_id'])){
    header('location:login.php');
  }
  

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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">                  
            <h1 style="text-align:center">Blog Site</h1>                          
      </div><!-- /.container-fluid -->
    </section>
    <?php
        $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
        $stmt->execute();
        $result=$stmt->fetchAll();

        if(!empty($_GET['pageid'])){
          $pageid=$_GET['pageid'];
        }else{
          $pageid=1;
        }
        $rec=4;
        $offect=($pageid-1)*$rec;
        $totalPage=ceil(count($result)/$rec);

        $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offect,$rec");
        $stmt->execute();
        $result=$stmt->fetchAll();

    ?>
    <!-- Main content -->
    <section class="content">
    <div class="row">
    <?php
      foreach($result as $value){
        ?>
        <div class="col-md-3">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div style="text-align:center;float:none " class="card-title">
                    <h6 style="height:50px;"><?php echo escape($value['title'])?></h6>
                </div>
                <!-- /.user-block -->
                
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="height:200px; !important" >
                
              <center><a href="blogdetail.php?id=<?php echo escape($value['id'])?>"><img src="admin/images/<?php echo $value['image']?>" alt="photo" style="height:150px; "></center></a>
                <!-- <p><?php echo escape($value['content'])?></p>                -->
              </div>  
            </div>
            <!-- /.card -->
          </div>
        <?php
      }
      
    ?>
        </div>
        
          

        
    </section>
    <nav aria-label="Page navigation example" >
  <ul class="pagination" style="float:right; margin-right:30px">
    <li class="page-item"><a class="page-link" href="?pageid=1">First</a></li>
    <li class="page-item <?php if($pageid<=1){echo 'disabled';}?>">
      <a class="page-link" href="?<?php if($pageid<=1){echo '#';}else{echo 'pageid='.($pageid-1);}?>">Previous</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="3"><?php echo $pageid?></a>
    </li>
    <li class="page-item <?php if($pageid>=$totalPage){echo 'disabled';}?>">
      <a class="page-link" href="?<?php if($pageid>=$totalPage){echo '#';}else{echo 'pageid='.($pageid+1);}?>">Next</a>
    </li>
    <li class="page-item"><a class="page-link" href="?<?php echo 'pageid='.$totalPage?>">Last</a></li>
  </ul>
</nav>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" type="button" class="btn btn-warning" style="margin-right:60px;">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#">Blog</a>.</strong> All rights reserved.
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
