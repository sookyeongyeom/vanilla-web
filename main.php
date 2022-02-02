<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <script>
        function auth(){
            var id = '<?=$_SESSION['id']?>';
            url = "mypage_check.php?id="+id;
            window.open(url,"auth","width=600,height=400");
        }
    </script>
</head>
<body>
    <h1>MAIN</h1>
    <a href="board.php">게시판</a>
    <a href="qna.php">문의글</a>
    <a href="javascript:void(0);" onclick="auth();">마이페이지</a>
    <?php
        if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
            echo "<p><button onclick=\"window.location.href='login.php'\">로그인</button> <button onclick=\"window.location.href='join.php'\">회원가입</button></p>";
        } else {
            $user_id = $_SESSION['id'];
            $user_name = $_SESSION['name'];
            echo "<p>$user_name($user_id)님 환영합니다.";
            echo "<p><button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        }
    ?>
</body>
</html>