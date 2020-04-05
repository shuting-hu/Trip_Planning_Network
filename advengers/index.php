<?php 
session_start();
// redirects to login if no active session
if (!isset($_SESSION["username"])) 
    header("location: login.html");
?>

<?php
include 'connect.php';
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

// if admin goto adminSettings.php else userSettings.php
function settingsButton() {
  global $conn;
  $username = $_SESSION["username"];
  if (true) { // (isset($_POST['btn_settings'])) {
    $sqladmin = "SELECT * FROM Admin WHERE username = '$username'";
    $isadmin = mysqli_query($conn, $sqladmin) or die(mysqli_error($conn));
    if (mysqli_num_rows($isadmin) > 0) {
      echo "<button class='side-post-button' onclick=document.location='adminSettings.php'>Settings</button>";
    } else {
      echo "<button class='side-post-button' onclick=document.location='userSettings.php'>Settings</button>";
    }
  }
}

/* SOURCE: https://blog.csdn.net/ljphhj/article/details/16853277 */
function loadPosts($postSet) {
  global $conn;
  $pagesize = 5;

  // get total # of posts
  $sql = "SELECT COUNT(*) FROM ".$postSet;
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

  $offset = $pagesize * ($page - 1);
  // retrieve post_id of the latest 5 posts; is "limit" a good choice here?
  $sql = "SELECT * FROM ".$postSet." ORDER BY trip_id DESC LIMIT $offset, $pagesize";
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
  
  echo "<div align='center'>Page ".$page." / ".$pages;
  echo "<br>";
  for ($i=1; $i<=$pages; $i++) {
    echo "<a href='index.php?page=".$i."'>[ ".$i." ]</a>";
    echo " ";
  }
  echo "</div>";
}

/***
 * helper functions
 */
function showName($trip_id) {
  global $conn;
  $sql = "select name, username from all_users where username = (select username from plans where trip_id = $trip_id)";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs);
  $username = $row['username'];
  echo "<p class='post-username'>".$row['name']
      . "<a href='searchbar-parser.php?query=$username' class='post-tag' style='margin-left:18px;'>@".$username."</a></p>";
}

function parseTags($location_id) {
  global $conn;
  $sql = "select * from location where id = $location_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs);
  // TODO: search
  $city = $row['city'];
  $province = $row['province'];
  $country = $row['country'];
  echo "<a href='searchbar-parser.php?query=$city' class='post-tag' style='margin-left:18px;'>#".$city." </a>"; 
  if(!empty($province)) 
    echo "<a href='searchbar-parser.php?query=$province' class='post-tag'> #".$province." </a>";
  echo "<a href='searchbar-parser.php?query=$country' class='post-tag'> #".$country."</a>";
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
    if ($row_type['type'] == 1) { // text
      renderText($post_id);
    } elseif ($row_type['type'] == 2) { // photo
      renderPhoto($post_id);
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
  echo "<p class='post-text'><label style=\"color: #aea6ed;font-size:20px\">&gt; </label>  ".$row['words']."</p>";
  // echo "<p class='post-text'><label style=\"color: #aea6ed;font-size:30px\">&#8727; </label> ".$row['words']."</p>";
}

function renderPhoto($post_id) {
  global $conn;
  $sql = "select caption, file_path from photo where post_id = $post_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  // photo
  echo "<div class='post-image'><img src=".$row['file_path']." class='image' alt='image'></div>";
  // caption
  if ($row['caption']) {
    echo "<p class='post-caption'>".$row['caption']."</p>";
  }

  echo "<br>";
}

function renderVideo($post_id) {
  global $conn;
  $sql = "select url from video where post_id = $post_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  $url = $row['url'];

  // SOURCE: https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
  // regex code 
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
  $youtube_id = $match[1];

  echo '<div><iframe class="post-video" width="550" height="320" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Page</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->
    <link href="./bootstrap/css/templates/dashboard.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/offcanvas.css" rel="stylesheet">
    <link href="./bootstrap/css/myappendix.css" rel="stylesheet">

    <style>
		  * {
          font-family: sans-serif;
        }

      #current-user {
        position: absolute;
        top: 280px;
        /* margin-bottom: 30px; */
        left: 100px;
        
        /* margin-bottom: 100px; */
      }

      a:link {
        color: #4B0082;
      }

      a:visited {
        color: #4B0082;
      }
      
      a:hover {
        color: #aea6ed;
      }

      #current-user-link {
        font-size: 30px;
        display: block;
        font-weight: bold;
        font-style: italic;
        color: #4B0082;
      }

      #current-user-link:hover {
        color: #aea6ed;
      }

      #btn_home {
        position: absolute;
        top: 8px;
        left: 8px;
        cursor: pointer;
        max-height: 38px;
        width: auto;
        height: auto;
        padding-top: 2px;
        padding-left: 6px;
        padding-bottom: 1px;
      }

      /* overwrite bootstrap css (myappendix.css) */
      p.post-caption {
        padding-top: 5px;
        /* padding-bottom: 5px; */
        font-size: 20px;
        color: #333333;
      }

      /* side-post-button, adapted from myappendix.css */
      /* .side-post-button {
        margin-top: 30px;
        margin-left: 68px;
        width: 150px;
        height: 50px;
        display: block;
        font-size: 18px;
        font-weight: bold;
        color: #4B0082;
        background-color: #ffffff;
        border: 2px solid #4B0082;
        border-radius: 8px;
        box-shadow: 0 0 5px #A9A9A9;
      }

      .side-post-button:hover {
        transition-duration: 0.4s;
        background-color: #4B0082;
        color: #ffffff;
      } */

      
    </style>
    <script>
        function goHome() {
            window.location = "index.php";
        }

    </script>
  </head>

  <body>
    <!-- search bar -->
	<div class="bar-container col-md-offset-3">
		<form action="searchbar-parser.php" method="get">
      <input size="100" name="query" class="search" placeholder="Search by tag, user, etc.">
		</form>
    </div>

    <!-- side navigation bar -->
    <div class="container-fluid">
      <div class="col-md-3 post-sidebar">
        <div class="home_btn">
          <img id="btn_home" src="images/webpage/origami.png" onclick="goHome()" width="100" height="100">
        </div>
        <div class="placeholder">
          <?php getPfp() ?>
        </div>
        <div id="current-user">
          <a id="current-user-link" href='searchbar-parser.php?query=<?php echo $_SESSION["username"]?>' class='post-tag' style='margin-left:18px;'><?php echo $_SESSION["username"]?></a>
        </div>
        <br>
          <!-- buttons -->
        <div>
          <button class="side-post-button" onclick="document.location='create.php'">Create Post</button>
          <?php settingsButton(); ?>
          <button class="side-post-button" onclick="document.location='logout.php'">Log Out</button>
        </div>
      </div>
    </div>

  <!-- main section -->
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-3 main">
    <?php 
    if (isset($_GET['search']) && $_GET['search'] == "true") { // show search result
      loadPosts("Subposts");
    } else { // normal view
      loadPosts("Trip_in");
    }
    ?>
  </div>
    
  </body>
</html>
