<?php
    session_start();
    include 'db.inc';
    $id = $_SESSION['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    $sql = "UPDATE member SET name='$name', phone='$phone', email='$email', address='$address' WHERE id='$id'";
    $res = mysqli_query($conn,$sql);

    if($res){
        echo "<script>alert('내 정보를 변경하였습니다!');";
        echo "window.location.href='mypage.php';</script>";
        exit;
    }
?>