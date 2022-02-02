<?php
    include 'db.inc';
    session_start();

    $pw0 = $_POST['pw0'];
    $pw1 = $_POST['pw1'];
    $pw2 = $_POST['pw2'];
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM member WHERE id='$id'";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));

    if($pw0!=$res['pw']){
        echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); history.back();</script>";
    } else {
        if($pw1==$pw2){
            $sql2 = "UPDATE member SET pw='$pw1' WHERE id='$id'";
            $res2 = mysqli_query($conn, $sql2);
            if($res2){
                echo "<script>alert('비밀번호가 변경되었습니다.'); opener.parent.location.href='mypage.php'; window.close();</script>";
                exit;
            }
        } else {
            echo "<script>alert('새로운 비밀번호가 일치하지 않습니다.'); history.back();</script>";
            exit;
        }
    }
?>