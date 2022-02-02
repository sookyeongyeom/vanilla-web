<?php
    session_start();
    if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
        echo "<script>alert('비회원입니다!');";
        echo "window.location.replace('login.php');</script>";
    }

    include 'db.inc';
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];

    $error = $_FILES['file']['error'];
    $tmpfile = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];
    $folder = "../file/upload/".$filename;

    if( $error != UPLOAD_ERR_OK ){
        switch( $error ) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<script>alert('파일이 너무 큽니다.');";
                        echo "window.history.back()</script>";
                        exit;
        }
    }

    move_uploaded_file($tmpfile, $folder);

    $sql = "INSERT INTO board(title, content, id, name, file, hit, created) VALUES ('$title', '$content', '$id', '$name', '$filename', 0, now());";

    $res = mysqli_query($conn, $sql);

    if($res) {
        echo "<script>alert('게시글이 작성되었습니다.');";
        echo "window.location.replace('board.php');</script>";
    } else {
        echo mysqli_error($conn);
    }
?>