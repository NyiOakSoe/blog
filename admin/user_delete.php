<?php
      require '../config/config.php';
      $id=$_GET['id'];
      $stmt=$pdo->prepare("DELETE FROM users WHERE id='$id'");
      $result=$stmt->execute();
      if($result){
        header('location:user.php');
      }