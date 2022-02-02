<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QnA</title>
    <script>
        function info() {
            var opt = document.getElementById("search_opt");
            var opt_val = opt.options[opt.selectedIndex].value;
            var info = ""
            if (opt_val=='title'){
                info = "제목을 입력하세요.";
            } else if (opt_val=='content'){
                info = "내용을 입력하세요.";
            } else if (opt_val=='name'){
                info = "작성자를 입력하세요.";
            }
            document.getElementById("search_box").placeholder = info;
        }
    </script>
</head>
<body>
    <button onclick="window.location.href='main.php'">메인으로</button> 
    <div><h2>문의글</h2></div>
    <button onclick="window.location.href='qna_write.php'">문의하기</button>
       <?php
            include 'db.inc';
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql = "SELECT * FROM qna";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 5;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql2 = "SELECT * FROM qna ORDER BY idx DESC limit $start, $per";
            $res2 = mysqli_query($conn, $sql2);

            if($total_post==0){
                echo "<h3>문의글이 없습니다.</h3>";
            } else { ?>
                <table class=middle>
                    <thead>
                        <tr align=center>
                            <th width=70>Post ID</th>
                            <th width=300>제목</th>
                            <th width=120>작성자</th>
                            <th width=120>작성일</th>
                            <th width=70>조회수</th>
                        </tr>
                    </thead> <?php
            while($row = mysqli_fetch_array($res2)){
        ?>
            <tbody>
                <tr align=center>
                    <td><?php echo $row['idx'];?></td> <?php
                    if($row['pw']){ ?>
                        <td><a href="qna_check.php?idx=<?=$row['idx']?>"><?php echo $row['title'];?>🔑</a></td> <?php
                    }else{ ?>
                        <td><a href="qna_check.php?idx=<?=$row['idx']?>"><?php echo $row['title'];?></a></td> <?php
                    } ?>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['created'];?></td>
                    <td><?php echo $row['hit'];?></td>
                </tr>
            </tbody>
        <?php } ?>
        </table>
        <?php } ?>
        <?php
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"qna.php?page=1\">◀ </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"qna.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"qna.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"qna.php?page=$total_page\">▶</a>";
            }
        ?>
        <form method="get" action="qna_search.php">
            <select name="cate" id="search_opt" onchange="info()">
                    <option value=title>제목</option>
                    <option value=content>내용</option>
                    <option value=name>작성자</option>
            </select>
            <input type=text name=search id="search_box" autocomplete="off" placeholder="제목을 입력하세요." required>
            <input type=submit value=검색>
        </form>
</body>
</html>