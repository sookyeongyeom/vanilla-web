<?php
    include 'db.inc';
    session_start();
    $idx = $_GET['idx'];
    $sql = "SELECT * FROM board where idx=$idx";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    if($_SESSION['id']!=$res['id']) {
        echo "<script>alert('권한이 없습니다!');";
        echo "history.back();</script>";
        exit;
    }

    $title = $_POST['title'];
    $content = $_POST['content'];

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

    if(!$filename){
        $sql2 = "UPDATE board SET title='$title', content='$content' WHERE idx=$idx";
    } else {
        $sql2 = "UPDATE board SET title='$title', content='$content', file='$filename' WHERE idx=$idx";
    }
    
    $res2 = mysqli_query($conn, $sql2);

    if($res2) {
        echo "<script>alert('게시글이 수정되었습니다.');";
        echo "window.location.href='board_view.php?idx=$idx';</script>";
    } else {
        echo mysqli_error($conn);
    }
?>