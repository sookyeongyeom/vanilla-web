<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Board</title>
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
    <div><h2>게시판</h2></div>
    <button onclick="window.location.href='board_write.php'">글쓰기</button>
    <table class=middle>
        <thead>
            <tr align=center>
                <th width=70>Post ID</th>
                <th width=300>제목</th>
                <th width=120>작성자</th>
                <th width=120>작성일</th>
                <th width=70>조회수</th>
                <th width=70>💜</th>
            </tr>
       </thead>
       <?php
            include 'db.inc';
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql = "SELECT * FROM board";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 5;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql2 = "SELECT * FROM board ORDER BY idx DESC limit $start, $per";
            $res2 = mysqli_query($conn, $sql2);

            while($row = mysqli_fetch_array($res2)){
                #좋아요 개수
                $post_idx = $row['idx'];
                $sql3 = "SELECT * FROM like_manager WHERE post_idx=$post_idx";
                $res3 = mysqli_num_rows(mysqli_query($conn, $sql3));
        ?>
            <tbody>
                <tr align=center>
                    <td><?php echo $row['idx'];?></td>
                    <td><a href="board_view.php?idx=<?=$row['idx']?>"><?php echo $row['title'];?></a></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['created'];?></td>
                    <td><?php echo $row['hit'];?></td>
                    <td><?php echo $res3?></td>
                </tr>
            </tbody>
        <?php } ?>
        </table>
        <?php
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"board.php?page=1\">◀ </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"board.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"board.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"board.php?page=$total_page\">▶</a>";
            }
        ?>
        <form method="get" action="board_search.php">
            <select name="cate" id="search_opt" onchange="info()">
                    <option value=title>제목</option>
                    <option value=content>내용</option>
                    <option value=name>작성자</option>
            </select>
            <input type=text name=search id="search_box" autocomplete="off" placeholder="제목을 입력하세요." required>
            <input type=submit value=검색>
                <p>
                    <input type=date name=date1>
                    ~
                    <input type=date name=date2>
                </p>
        </form>
</body>
</html>