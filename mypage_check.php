<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auth</title>
</head>
<body>
    비밀번호를 입력하세요.
    <form method=post action=mypage_check.php>
        <p><input type=password name=pw> <input type=submit value=확인></p>
    </form>
</body>
</html>
<?php
    include 'db.inc';
    session_start();

    $pw = $_POST['pw'];
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM member WHERE id='$id'";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));

    if(isset($_POST['pw'])){
        if($pw==$res['pw']){
            echo "<script>alert('마이페이지에 접근합니다.'); opener.parent.location.href='mypage.php'; window.close();</script>";
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
            exit;
        }
    }
?>