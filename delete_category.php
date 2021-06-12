<?php
 include_once'db/connect_db.php';
 session_start();
 if($_SESSION['role']!=="Admin"){
   header('location:index.php');
 }

$delete = $pdo->prepare("UPDATE tbl_category SET deleteC=1 WHERE cat_id = '".$_GET['id']." '");
if($delete->execute()){
    header('location:category.php');
}


