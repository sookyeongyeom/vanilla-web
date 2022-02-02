<?php
    session_start();
    include 'db.inc';

    $cate = $_GET['cate'];
    $search = $_GET['search'];
    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];

    switch($cate){
        case "title":
            $ct = "제목";
            break;
        case "content":
            $ct = "내용";
            break;
        case "name":
            $ct = "작성자";
            break;
    }

    $last = iconv_substr($search, -1, 1, "utf-8");
    $dec = substr(mb_convert_encoding($last,'HTML-ENTITIES','UTF-8'),2,-1);
    $nums = array("3","6","0");

    if($dec>=44032 && $dec<=55203){
        if(($dec-44032)%28!=0){
            $josa = "으로";
        }else{
            $josa = "로";
        }
    }elseif(in_array($last, $nums)){
        $josa = "으로";
    }else{
        $josa = "로";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
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
    <button onclick="window.location.href='board.php'">게시판</button>
    <h2>[<?=$ct?> : <?=$search?>] <?=$josa?> 검색한 결과입니다.</h2>
    <?php
    if($date1 && $date2){ ?>
        <h4><?=$date1?> ~ <?=$date2?></h4> <?php
    } else { ?>
        <h4>기간을 설정하지 않았습니다.</h4> <?php
    }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            if($date1 && $date2){
                $sql = "SELECT * FROM board WHERE $cate LIKE '%$search%' AND created BETWEEN '$date1' AND '$date2'";
            } else {
                $sql = "SELECT * FROM board WHERE $cate LIKE '%$search%'";
            }
            
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 5;

            $start = ($page-1)*$per;
        
            if($date1 && $date2){
                $sql2 = "SELECT * FROM board WHERE $cate LIKE '%$search%' AND created BETWEEN '$date1' AND '$date2' ORDER BY idx DESC limit $start, $per";
            } else {
                $sql2 = "SELECT * FROM board WHERE $cate LIKE '%$search%' ORDER BY idx DESC limit $start, $per";
            }

            $res2 = mysqli_query($conn, $sql2);

            if($total_post==0){
                echo "<h3>검색 결과가 없습니다.</h3>";
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
                                <td><a href="view.php?id=<?=$row['id']?>"><?php echo $row['title'];?></a></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['created'];?></td>
                                <td><?php echo $row['hit'];?></td>
                                <td><?php echo $res3?></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            <?php } ?>
    <div class=bottom>
    <?php
        if($page > 1){
            echo "<a href=\"board_search.php?page=1&cate=$cate&search=$search&date1=$date1&date2=$date2\">◀ </a>";
        }
        $total_page = ceil($total_post / $per);
        $page_num = 1;
        while($page_num <= $total_page){
            if($page==$page_num){
                echo "<a style=\"color:hotpink;\" href=\"board_search.php?page=$page_num&cate=$cate&search=$search&date1=$date1&date2=$date2\">$page_num </a>";
            } else {
            echo "<a href=\"board_search.php?page=$page_num&cate=$cate&search=$search&date1=$date1&date2=$date2\">$page_num </a>"; }
            $page_num++;
        }
        if($page < $total_page){
            echo "<a href=\"board_search.php?page=$total_page&cate=$cate&search=$search&date1=$date1&date2=$date2\">▶</a>";
        }
    ?>
    </div>
    <div class=search>
    <form method="get" action="board_search.php">
        <select name="cate" id="search_opt" onchange="info()">
            <option value=title>제목</option>
            <option value=content>내용</option>
            <option value=name>작성자</option>
        </select>
        <input class=textform type=text name=search id="search_box" autocomplete="off" value="<?=$search?>" placeholder="제목을 입력하세요." required>
        <input class=submit type=submit value=검색>
        <p>
        <input type=date value="<?=$date1?>" name=date1>
        ~
        <input type=date value="<?=$date2?>" name=date2>
        </p>
    </form>
    </div>
</body>
</html>