<?php
    session_start();
    include 'db.inc';
    $idx = $_GET['idx'];
    $id = $_SESSION['id'];

    $sql = "SELECT * FROM board WHERE idx=$idx";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    if($id == $res['id']){
        echo "<script>alert('자신의 게시글입니다!');";
        echo "history.back()</script>";
        exit;
    }

    $sql2 = "SELECT * FROM like_manager WHERE post_idx='$idx' and liker_id='$id'";
    $res2 = mysqli_fetch_array(mysqli_query($conn, $sql2));
    if($res2){
        echo "<script>alert('이미 공감한 게시글입니다!');";
        echo "history.back()</script>";
        exit;
    }

    $sql3 = "INSERT INTO like_manager(post_idx, liker_id) VALUES ('$idx', '$id');";
    $res3 = mysqli_query($conn, $sql3);
    if($res){
        echo "<script>alert('공감했습니다!');";
        echo "history.back()</script>";
    }
?>