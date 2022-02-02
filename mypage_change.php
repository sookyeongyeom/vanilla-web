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
    <title>Change Info</title>
    <script>
        function find_address(){
                url = "address.php";
                window.open(url,"address",'width=500, height=400, scrollbars=no, resizable=no');
            }
        function auth(){
                var id = '<?=$_SESSION['id']?>';
                url = "mypage_check_pw.php";
                window.open(url,"auth","width=600,height=400");
            }
    </script>
</head>
<body>
    <button onclick="window.location.href='mypage.php'">마이페이지</button>
    <h2>내 정보 변경</h2>
    <button onclick="window.location.href='mypage_post.php'">내가 작성한 글</button>
    <button onclick="window.location.href='mypage_like.php'">내가 공감한 글</button>
    <button onclick="window.location.href='mypage_change.php'">내 정보 변경</button>
    <div class=middle>
    <form method=post action=mypage_change_ok.php>
        <table>
            <tr>
                <th>ID</th>
                <td><?=$res['id']?></td>
            </tr>
            <tr>
                <th>PW</th>
                <td><input type=button value='비밀번호 변경하기' onclick='auth()'></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><input type=text name=name value='<?=$res['name']?>'></td>
            </tr>
            <tr>
                <th>연락처</th>
                <td><input type=text name=phone value='<?=$res['phone']?>'></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type=text name=email value='<?=$res['email']?>'></td>
            </tr>
            <tr>
                <th>주소</th>
                <td><input type=text name=address id=address value='<?=$res['address']?>' onclick='find_address();'></td>
            </tr>
        </table>
        <input type=submit value=변경하기>
    </form>
</div>
</body>
</html>