<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QnA Write</title>
    <script>
        function key(){
            qnaform = document.getElementById("qnaform")
            if(document.getElementById("pw").value != ""){
                if(window.confirm("비밀글로 설정하시겠습니까?")){
                    qnaform.submit();
                }
            } else {
                if(window.confirm("공개글로 설정하시겠습니까?")){
                    qnaform.submit();
                }
            }
        }
    </script>
</head>
<body>
    <button onclick="window.location.href='qna.php'">문의게시판</button>
    <h2>문의글 작성</h2>
    <form id=qnaform method="post" action="qna_write_ok.php" autocomplete="off">
        <p><input type=text size=25 name="title" placeholder="제목" required></p>
        <hr width=250px align="left">
        <p><textarea cols=35 rows=15 name="content" placeholder="내용을 입력하세요." required></textarea></p>
        <p>이름 <input type=text name="name" required><br>
        연락처 <input type=text name="phone" required><br>
        비밀번호 <input type=password name="pw" id="pw" placeholder='입력 시 비밀글로 설정됩니다.'></p>
        <p><input type="button" onclick="key();" value="글쓰기"></p>
    </form>
</body>
</html>