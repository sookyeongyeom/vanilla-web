<?php
    session_start();
    include 'db.inc';
    $idx = $_GET['idx'];
    $id = $_SESSION['id'];

    $sql = "SELECT * FROM like_manager WHERE post_idx='$idx' and liker_id='$id'";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    if(!$res){
        echo "<script>alert('공감하지 않은 게시글입니다!');";
        echo "window.history.back()</script>";
        exit;
    }

    $sql2 = "DELETE FROM like_manager WHERE post_idx='$idx' and liker_id='$id';";
    $res2 = mysqli_query($conn, $sql2);
    if($res2){
        echo "<script>alert('공감을 취소했습니다!');";
        echo "window.history.back()</script>";
    }
?>