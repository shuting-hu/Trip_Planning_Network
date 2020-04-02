<?php 
session_start();
?>


<?php
include'connect.php';
$conn = OpenCon();
  
function getPfp() {
  global $conn;
  $username = $_SESSION["username"];
  $sql = "select profile_picture from regular_user where username = '$username'";
  $rsResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = $rsResult->fetch_array(MYSQLI_ASSOC);
  $path = $row['profile_picture'];
  if (empty($path)) {
    echo "<img src='./images/default.png' class='pfp img-responsive' alt='pfp'>";
  } else {
    echo "<img src=$path class='pfp img-responsive' alt='pfp'>";
  }
}

function loadPosts () {
  // username, title, tags
  
  // media
  renderMedia();
  
  // caption, date
}

/**
 * helper functions
 */

/* SOURCE: https://www.runoob.com/w3cnote/php-mysql-pagination.html */
function renderMedia () { 
  $num_rec_per_page=10;   // 每页显示数量
  mysql_connect('localhost','root','');  // 数据库连接
  mysql_select_db('apex1');  // 数据库名
  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
  $start_from = ($page-1) * $num_rec_per_page; 
  $sql = "SELECT * FROM student LIMIT $start_from, $num_rec_per_page"; 
  $rs_result = mysql_query ($sql); // 查询数据
  ?> 
  <table>
  <tr><td>Name</td><td>Phone</td></tr>
  <?php 
  while ($row = mysql_fetch_assoc($rs_result)) { 
  ?> 
              <tr>
              <td><?php echo $row['Name']; ?></td>
              <td><?php echo $row['Phone']; ?></td>            
              </tr>
  <?php 
  }; 
  ?> 
  </table>
  <?php 
  $sql = "SELECT * FROM student"; 
  $rs_result = mysql_query($sql); //查询数据
  $total_records = mysql_num_rows($rs_result);  // 统计总共的记录条数
  $total_pages = ceil($total_records / $num_rec_per_page);  // 计算总页数

  echo "<a href='pagination.php?page=1'>".'|<'."</a> "; // 第一页

  for ($i=1; $i<=$total_pages; $i++) { 
              echo "<a href='pagination.php?page=".$i."'>".$i."</a> "; 
  }; 
  echo "<a href='pagination.php?page=$total_pages'>".'>|'."</a> "; // 最后一页
}

function renderText() {

}

function renderImage() {

}

function renderVideo() {

}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Page</title>

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/dashboard.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/offcanvas.css" rel="stylesheet">
    <link href="./bootstrap/css/myappendix.css" rel="stylesheet">
  </head>

  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Advengers</a><!-- TODO: nah it shouldn't be a link -->
        </div>
        <!-- search engine -->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="create.html">Create Post</a></li>
          </ul>
          <form class="navbar-form navbar-right" action="search.php">
            <input type="text" class="form-control" placeholder="Search by tag, user, etc.">
            <!-- how do we distinguish different types of keywords? -->
          </form>
        </div>
      </div>
    </nav>

    <!-- side navigation bar -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-3 sidebar post-sidebar">
          <div class="placeholder">
             <?php getPfp() ?> 
          </div>

          <!-- other functionalities -->
          <div>
              <button class="side-post-button" onclick="document.location='profile.php'">Profile</button>
              <button class="side-post-button" onclick="document.location='logout.php'">Logout</button>
          </div>
        </div>

      </div>
    </div>

  <!-- main section -->
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-3 main">
          <!-- post area -->
          <!-- display <= 5 latest posts-->
          <!-- what if have <5 posts? how to do a while loop? -->
          <div class="row post-block">
            <h2 class="post-heading">Heading</h2>
            <!-- TODO: display block for tags -->
            <p class="post-text"><?php loadPosts(); ?></p>
          </div>
  </div>
    
  </body>
</html>
