<?php
    session_start();
    include 'db.inc';

    if(!isset($_SESSION['id']) || !isset($_SESSION['name'])){
        echo "<script>alert('비회원입니다!');";
        echo "window.location.href=\"../main.php\";</script>";
    }

    $id = $_SESSION['id'];
    $sql = "SELECT * FROM member WHERE id='$id'";
    $res = mysqli_fetch_array(mysqli_query($conn, $sql));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
</head>
<body>
    <button onclick="window.location.href='main.php'">메인으로</button>
    <h2>마이페이지</h2>
    <button onclick="window.location.href='mypage_post.php'">내가 작성한 글</button>
    <button onclick="window.location.href='mypage_like.php'">내가 공감한 글</button>
    <button onclick="window.location.href='mypage_change.php'">내 정보 변경</button>
    <div class=middle>
    <table>
        <tr>
            <th>ID</th>
            <td><?=$res['id']?></td>
        </tr>
        <tr>
            <th>이름</th>
            <td><?=$res['name']?></td>
        </tr>
        <tr>
            <th>연락처</th>
            <td><?=$res['phone']?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?=$res['email']?></td>
        </tr>
        <tr>
            <th>주소</th>
            <td><?=$res['address']?></td>
        </tr>
        <tr>
            <th>가입일</th>
            <td><?=$res['created']?></td>
        </tr>
    </table>
</div>
</body>
</html>