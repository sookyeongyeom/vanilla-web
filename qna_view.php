<?php
    include 'db.inc';
    session_start();

    $idx = $_GET['idx'];
    $sql = "SELECT * FROM qna where idx=$idx";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    $hit = $res['hit'];

    #타인 조회 시 조회수 증가
    $sql2 = "UPDATE qna SET hit=hit+1 WHERE idx=$idx";
    $res2 = mysqli_query($conn, $sql2);
    $hit += 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QnA View</title>
</head>
<body>
    <button onclick="window.location.href='qna.php'">문의게시판</button><br>
    제목 : <?=$res['title']?><br>
    작성자 : <?=$res['name']?><br>
    <hr>
    내용 : <?=$res['content']?><br>
    <hr>
    작성일 : <?=$res['created']?><br>
    조회수 : <?=$hit?><br>
    <hr>
    <button onclick="window.location.href='qna_remove_check.php?idx=<?=$res['idx']?>'">삭제</button>
</body>

</html>