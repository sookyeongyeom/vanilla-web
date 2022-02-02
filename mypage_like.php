<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Likes</title>
</head>
<body>
    <button onclick="window.location.href='mypage.php'">마이페이지</button> 
    <div><h2>내가 공감한 글</h2></div>
       <?php
            include 'db.inc';
            session_start();
            
            $id = $_SESSION['id'];

            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql0 = "SELECT * FROM like_manager WHERE liker_id='$id'";
            $res0 = mysqli_query($conn, $sql0);
            $like = array();
            while($row0 = mysqli_fetch_array($res0)){
                array_push($like, $row0['post_idx']);
            }
            $like = join(',',$like);

            $sql = "SELECT * FROM board WHERE idx IN ($like);";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 5;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql2 = "SELECT * FROM board WHERE idx IN ($like) ORDER BY idx DESC limit $start, $per";
            $res2 = mysqli_query($conn, $sql2);

            if($total_post==0){
                echo "<h3>공감한 글이 없습니다.</h3>";
            } else { ?>
                <table>
                    <thead>
                        <tr align=center>
                            <th width=70>Post ID</th>
                            <th width=300>제목</th>
                            <th width=120>작성자</th>
                            <th width=120>작성일</th>
                            <th width=70>조회수</th>
                            <th width=70>💜</th>
                            <th width=70>취소</th>
                        </tr>
                    </thead> <?php
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
                    <td><button onclick="location.href='board_unlike_ok.php?idx=<?=$post_idx?>'">X</button></td>
                </tr>
            </tbody>
        <?php } ?>
        </table>
    <?php } ?>
        <?php
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"mypage_like.php?page=1\">◀ </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"mypage_like.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"mypage_like.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"mypage_like.php?page=$total_page\">▶</a>";
            }
        ?>
</body>
</html>