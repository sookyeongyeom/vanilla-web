<?php
    include 'db.inc';
    session_start();
    #비회원 접근 금지
    if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
        echo "<script>alert('비회원입니다!');";
        echo "window.location.replace('login.php');</script>";
    }

    $id = $_SESSION['id'];
    $idx = $_GET['idx'];
    $sql = "SELECT * FROM board where idx=$idx";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
    $hit = $res['hit'];

    #타인 조회 시 조회수 증가
    if($_SESSION['id'] != $res['id']){
        $sql2 = "UPDATE board SET hit=hit+1 WHERE idx=$idx";
        $res2 = mysqli_query($conn, $sql2);
        $hit += 1;
    }

    #좋아요 확인
    $sql3 = "SELECT * FROM like_manager WHERE post_idx=$idx and liker_id='$id'";
    $res3 = mysqli_fetch_array(mysqli_query($conn, $sql3));

    #좋아요 개수
    $sql4 = "SELECT * FROM like_manager WHERE post_idx=$idx";
    $res4 = mysqli_num_rows(mysqli_query($conn, $sql4));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View</title>
</head>
<body>
    <button onclick="window.location.href='main.php'">메인으로</button><br>
    제목 : <?=$res['title']?><br>
    작성자 : <?=$res['name']?><br>
    <hr>
    <img width=480px src="../file/upload/<?=$res['file']?>"><br>
    내용 : <?=$res['content']?><br>
    <p><a href="../file/upload/<?=$res['file'];?>"download><?=$res['file'];?></a></p>
    <hr>
    작성일 : <?=$res['created']?><br>
    조회수 : <?=$hit?><br>
    좋아요 : <?=$res4?><br>
    <hr>
<?php
    if($_SESSION['id']==$res['id']){ ?>
        <button onclick="window.location.href='board_update.php?idx=<?=$res['idx']?>'">수정</button>
        <button onclick="window.location.href='board_remove_ok.php?idx=<?=$res['idx']?>'">삭제</button>
<?php } else {
            if($res3){ ?>
                <button onclick="window.location.href='board_unlike_ok.php?idx=<?=$res['idx']?>'">좋아요 취소</button>
<?php       } else { ?>
                <button onclick="window.location.href='board_like_ok.php?idx=<?=$res['idx']?>'">좋아요</button>
<?php       } 
    } ?>
</body>

</html>