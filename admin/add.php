<?php
  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id'])){
    header('location:login.php');
  };
  
  if(isset($_POST['addBTN'])){
    if(empty($_POST['title']) || empty($_POST['content'])){
      if(empty($_POST['title'])){
        $titleError="! Need to fill Title";
      }
      if(empty($_POST['content'])){
        $contentError="! Need to fill Content";
      }
    }else{
      $img_name=$_FILES['image']['name'];
    $img_tmp=$_FILES['image']['tmp_name'];
    $file='images/'.$img_name;
    $imgtype=pathinfo($file,PATHINFO_EXTENSION);
    if($imgtype!='png' && $imgtype!='jpg' && $imgtype!='jepg'){
        echo "<script>alert('Need image is pnd or jpg or jepg')</script>";
    }else{
        move_uploaded_file($img_tmp,$file);
        $title=$_POST['title'];
        $content=$_POST['content'];

        $stmt=$pdo->prepare("INSERT INTO posts(title,content,image,user_id) VALUES (:title,:content,:image,:user_id)");
        $result=$stmt->execute(
            array(
                ':title'=>$title,
                ':content'=>$content,
                ':image'=>$img_name,
                ':user_id'=>$_SESSION['user_id'],
            )
        );

        if($result){
            echo "<script>alert('Create Blog is successful')</script>";
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($titleError)?$titleError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Content</label><br>
                                <textarea name="content" id="" class="form-control" cols="30" rows="10"></textarea>
                                <p style="color:red"><?php echo !empty($contentError)?$contentError:'';?></p>
                              </div>
                            <div class="form-group">
                                <label for="">Image</label><br>
                                <input type="file" name="image"  id="">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit" name="addBTN" class="btn btn-success">
                                <a href="index.php" type="button" class="btn btn-warning">Back</a>
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