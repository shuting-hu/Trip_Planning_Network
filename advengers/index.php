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
/* SOURCE: https://blog.csdn.net/ljphhj/article/details/16853277 */
function loadPosts() {
  global $conn;
  $pagesize = 5;

  // get total # of posts
  $sql = "select count(*) from trip_in";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs);
  $numrows = $row[0];

  // get total # of pages
  $pages = intval($numrows/$pagesize);
  if ($numrows%$pagesize) {
    $pages++;
  }

  // get current page #
  if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
  } else {
    $page = 1;
  }

  $offset=$pagesize*($page - 1);
  // retrieve post_id of the latest 5 posts; is "limit" a good choice here?
  $sql = "select * from trip_in order by trip_id desc limit $offset,$pagesize";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  // render posts
  while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
      echo "<div class='row post-block'>";
      // username
      showName($row['trip_id']);
      // title
      echo "<p class='post-heading'>".$row['title']."</p>";
      // tags
      parseTags($row['location_id']);
      // duration?
      // media
      renderMedia($row['trip_id']);
      echo "</div>";
  }
  
  echo "<div align='center' class='post-bottom'>Page ".$page." / ".$pages;
  echo "<br>";
  for ($i=1; $i<=$pages; $i++) 
    echo "<a href='index.php?page=".$i."'> [".$i." ]</a>";
  echo "</div>";
}

/***
 * helper functions
 */
function showName($trip_id) {
  global $conn;
  $sql = "select name from all_users where username = (select username from plans where trip_id = $trip_id)";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs);
  echo "<p class='post-username'>".$row['name']."</p>";
}

function parseTags($location_id) {
  global $conn;
  $sql = "select * from location where id = $location_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs);
  // TODO: search
  echo "<a href='search.php' class='post-tag' style='margin-left:18px;'>#".$row['city']." </a>"; 
  if(!empty($row['province']))
    echo "<a href='search.php' class='post-tag'> #".$row['province']." </a>";  
  echo "<a href='search.php' class='post-tag'> #".$row['country']."</a>";
}

function renderMedia($trip_id) {
  global $conn;
  $sql = "select post_id from posts where trip_id = $trip_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
    $post_id = $row['post_id'];
    $sql_type = "select type from media where post_id = ".$post_id;
    $rs_type = mysqli_query($conn, $sql_type) or die(mysqli_error($conn));
    $row_type = mysqli_fetch_array($rs_type, MYSQLI_ASSOC);
    if ($row_type['type']==1) { // text
      renderText($post_id);
    } elseif ($row_type['type']==2) { // photo
      echo "photo";
      renderPhoto($post_id);
      echo "video";
    } else { // video
      renderVideo($post_id);
    }
  }
  // date
}

function renderText($post_id) {
  global $conn;
  $sql = "select words from text where post_id = $post_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  echo "<p class='post-text'>".$row['words']."</p>";
}

function renderPhoto($post_id) {}

function renderVideo($post_id) {}
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
          <form action="search.php" class="navbar-form navbar-right" action="search.php">
            <input name="input" class="form-control" placeholder="Search by tag, user, etc.">
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
    <?php loadPosts(); ?>
  </div>
    
  </body>
</html>
