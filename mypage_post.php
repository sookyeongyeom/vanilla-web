<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Post</title>
</head>
<body>
    <button onclick="window.location.href='mypage.php'">마이페이지</button> 
    <div><h2>내가 작성한 글</h2></div>
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
            session_start();

            $id = $_SESSION['id'];
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql = "SELECT * FROM board WHERE id='$id'";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 5;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql2 = "SELECT * FROM board WHERE id='$id' ORDER BY idx DESC limit $start, $per";
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
                echo "<a href=\"mypage_post.php?page=1\">◀ </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"mypage_post.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"mypage_post.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"mypage_post.php?page=$total_page\">▶</a>";
            }
        ?>
</body>
</html>