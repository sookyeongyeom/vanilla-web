<?php
    session_start();

    include 'db.inc';
    $title = $_POST['title'];
    $content = $_POST['content'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $pw = $_POST['pw'];

    if($pw){
        $sql = "INSERT INTO qna(title, content, name, phone, pw, created) VALUES ('$title', '$content', '$name', '$phone', '$pw', now());";
    } else {
        $sql = "INSERT INTO qna(title, content, name, phone, created) VALUES ('$title', '$content', '$name', '$phone', now());";
    }

    $res = mysqli_query($conn, $sql);

    if($res) {
        echo "<script>alert('문의글이 작성되었습니다.');";
        echo "window.location.replace('qna.php');</script>";
    } else {
        echo mysqli_error($conn);
    }
?>