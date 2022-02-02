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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
</head>
<body>
    <h2>게시글 수정</h2>
    <form method="post" action="board_update_ok.php?idx=<?=$idx?>" enctype="multipart/form-data" autocomplete="off">
        <p><input type=text size=25 name=title value='<?=$res['title']?>' placeholder="제목" sqluired></p>
        <hr width=250px align="left">
        <p><textarea cols=35 rows=15 name=content placeholder="내용을 입력하세요."><?=$res['content']?></textarea></p>
        <p><input class=file id="input-file" type=file name=file></p>
        <p><input type="submit" value="수정하기"></p>
    </form>
</body>
</html>