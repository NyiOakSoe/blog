<?php
  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id'])){
    header('location:login.php');
  };
?>
<?php
  include ('header.html');
?>
    
    <!-- /.content-header -->
    <?php
      
        if(!empty($_GET['pageno'])){
          $pageno=$_GET['pageno'];
        }else{
          $pageno=1;
        }
        $numofrecs=2;
        $offset=($pageno -1) * $numofrecs;
  
        if(empty($_POST['search'])){
      $stmt=$pdo->prepare("SELECT * FROM users ");
      $stmt->execute();
      $row_result=$stmt->fetchAll();
      $total_page=ceil(count($row_result) / $numofrecs);
  
      $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numofrecs ");
      $stmt->execute();
      $result=$stmt->fetchAll();
      
      $result_role=[];
      foreach($result as $key => $value){
        $role=$result[$key]['role'];
        $stmt_role=$pdo->prepare("SELECT * FROM users WHERE role=$role");
        $stmt_role->execute();
        $result_role[]=$stmt_role->fetchAll();
      }
      
            
      }else{          
          $search=$_POST['search'];            
          $stmt=$pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search%'   ORDER BY id DESC   ");
          $stmt->execute();
           $result=$stmt->fetchAll();
           $result_role=[];
          foreach($result as $key => $value){
            $role=$result[$key]['role'];
            $stmt_role=$pdo->prepare("SELECT * FROM users WHERE role=$role");
            $stmt_role->execute();
            $result_role[]=$stmt_role->fetchAll();
          }

           
      
    }
      
    
    ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Lists</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="user_add.php" type="button" class="btn btn-success">Create User</a><br><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th style="width: 160px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                      $i=1;
                      foreach ($result as $key => $value) {
                        ?>
                    
                        <tr>
                        <td><?php echo escape($i); ?></td>
                        <td><?php echo escape($value['name']); ?></td>
                        <td><?php echo escape($value['email']); ?></td>
                        <td><?php if($result_role[$key][0]['role']==1){echo "admin";}else{echo "User";} ; ?></td>
                        <td>
                          <a href='user_edit.php?id=<?php echo $value['id']; ?>' type='button' class='btn btn-warning'>Edit</a> 
                          <a href='user_delete.php?id=<?php echo $value['id']; ?>' type='button' class='btn btn-danger'>Delete</a> 
  
                        </td>
                      </tr>
                      <?php
                      $i++;
                      }
                    }
                    
                    ?>
                    
                    
                  </tbody>
                </table>
                <br>
                <nav aria-label="Page navigation example">
                  <ul class="pagination" style="float:right">
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                    <a class="page-link" href="?pageno=1">First</a>
                  </li>
                  <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                    <a class="page-link" href="?<?php if($pageno<=1){echo "#";}else{echo "pageno=".($pageno-1);} ?>">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="?pageno=<?php echo $pageno;?>"><?php echo $pageno;?></a>
                  </li>
                  <li class="page-item <?php if($pageno>=$total_page){echo 'disabled';} ?>">
                    <a class="page-link" href="?<?php if($pageno>=$total_page){echo "#";}else{echo "pageno=".($pageno+1);} ?>">Next</a>
                  </li>
                  <li class="page-item <?php if($pageno>=$total_page){echo 'disabled';} ?>">
                    <a class="page-link" href="?pageno=<?php echo $total_page?>">Last</a>
                  </li>
                </ul>
              </nav>
              </div>
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php
    include ('footer.html');
  ?>