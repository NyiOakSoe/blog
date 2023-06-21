<?php
  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id'])){
    header('location:login.php');
  };
  $id=$_GET['id'];
  $stmt=$pdo->prepare("SELECT * FROM posts WHERE id=$id");
  $stmt->execute();
  $result=$stmt->fetchAll();
  
  if(isset($_POST['addBTN'])){
    if(empty($_POST['title']) || empty($_POST['content'])){
        if(empty($_POST['title'])){
          $titleError="! Need to fill Title";
        }
        if(empty($_POST['content'])){
          $contentError="! Need to fill Content";
        }
    }else{
        $title=$_POST['title'];
    $content=$_POST['content'];
    $id=$_POST['id'];
    if($_FILES['image']['name']){
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
                $id=$_POST['id'];
                $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content', image='$img_name' WHERE id='$id'");
                $result=$stmt->execute();
                if($result){
                    echo "<script>alert('Blog is successful Updated');window.location.href='index.php'</script>";
                    
                }
            }
    }else{
           
                $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
                $result=$stmt->execute();
                if($result){
                    echo "<script>alert('Blog is successful Updated');window.location.href='index.php'</script>";
                    header('location:index.php');
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
                        <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                                
                                <input type="hidden" name="id" value="<?php echo  escape($result[0]['id']); ?>" class="form-control" id="" >
                            </div>
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" value="<?php echo  escape($result[0]['title']); ?>" class="form-control" id="" >
                                <p style="color:red"><?php echo !empty($titleError)?$titleError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Content</label><br>
                                <textarea name="content" id=""  class="form-control" cols="30" rows="10"><?php echo escape($result[0]['content']) ?></textarea>
                                <p style="color:red"><?php echo !empty($contentError)?$contentError:'';?></p>
                            </div>
                            <div class="form-group">
                                <label for="">Image</label><br>
                                <img src="images/<?php echo escape($result[0]['image']); ?>" alt="" width='150' height='150'><br><br>
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