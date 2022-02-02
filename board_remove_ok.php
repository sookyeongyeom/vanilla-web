<?php
    include 'db.inc';
    session_start();
    $idx = $_GET['idx'];

    $sql = "SELECT * FROM board WHERE idx=$idx";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    if($_SESSION['id'] != $res['id']){
        echo "<script>alert('권한이 없습니다!');";
        echo "window.history.back()</script>";
        exit;
    }

    $sql2 = "
    DELETE FROM board WHERE idx=$idx;
    ";

    $res2 = mysqli_multi_query($conn, $sql2);

    echo "<script>alert('게시글이 삭제되었습니다!');";
    echo "window.location.href='board.php';</script>";
?>