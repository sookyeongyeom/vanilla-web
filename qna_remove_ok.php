<?php
    include 'db.inc';
    session_start();
    $idx = $_GET['idx'];

    $sql = "DELETE FROM qna WHERE idx=$idx;";

    $res = mysqli_multi_query($conn, $sql);

    if($res){
        echo "<script>alert('문의글이 삭제되었습니다!');";
        echo "window.location.href='qna.php';</script>";
    }
?>