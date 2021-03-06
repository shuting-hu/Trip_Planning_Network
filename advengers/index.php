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

      // media
      renderMedia($row['trip_id']);

      // duration?
      $duration = getDuration($row['trip_id']);

      // description?
      $desc = getDesc($row['trip_id']);

      // attraction
      $attrs = getAttractions($row['trip_id']);

      // activity
      $acts = getActivities($row['trip_id']);

      // restaurant   
      $rests = getRestaurants($row['trip_id']); 

      $str = "<div>"
              . "<p>" . $row['title'] . "<p>"
              . "&#x2731; Description: <br>&nbsp;&nbsp;&nbsp;&nbsp;" . $desc . "<br>"
              . "&#x2731; Duration:  " . $duration . "<br>"
              . $attrs
              . $acts
              . $rests . "<br>"
              . "</div>";

      
      echo "<button class=\"mini-btn\" id=\"show-plan\" onclick=\"on('" . $str ."')\">Show Plan</button>";
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
  // get user-specified columns
  $select = "";
  if (isset($_GET['filter_submit'])) {
    $select_comma = false;
    if (isset($_GET['city'])) {
      $select = "city";
      $select_comma = true;
    }
    if (isset($_GET['province'])) {
      if ($select_comma) 
        $select = $select.", ";
      $select = $select."province";
      $select_comma = true;
    }
    if (isset($_GET['country'])) {
      if ($select_comma) 
        $select = $select.", ";
      $select = $select."country";
    }
  } else {
    $select = "city, province, country";
  }

  // query & display
  if (!empty($select)) {
    $sql = "select $select from location where id = $location_id";
    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($rs);
    
    echo "<div style='margin-left: 18px;'>";
    if(isset($row['city'])) {
      $city = $row['city'];
      echo "<a href='searchbar-parser.php?query=$city' class='post-tag'>#".$city." </a>"; 
    }
    if(isset($row['province'])) {
      $province = $row['province'];
      echo "<a href='searchbar-parser.php?query=$province' class='post-tag'> #".$province." </a>";
    }
    if(isset($row['country'])) {
      $country = $row['country'];
      echo "<a href='searchbar-parser.php?query=$country' class='post-tag'> #".$country."</a>";
    }
    echo "</div>";
  }
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
    echo "<p style='font-size: 14px; text-align: center; margin-left: -40px; color: #606060;'>".$row['caption']."</p>";
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

function getDuration($trip_id) {
  global $conn;
  $sql = mysqli_query($conn, "SELECT duration FROM Trip_In WHERE trip_id = $trip_id") or die (mysqli_error($conn));
  if (mysqli_num_rows($sql) > 0) {
    // $temp = ($sql->fetch_assoc())['duration'];
    return ($sql->fetch_assoc())['duration'];
    // return "$temp";
  } else {
    return "N/A";
  }
}

function getDesc($trip_id) {
  global $conn;
  $sql = mysqli_query($conn, "SELECT description FROM Trip_In
                              WHERE trip_id = $trip_id AND description IS NOT NULL") or die (mysqli_error($conn));
  if (mysqli_num_rows($sql) > 0) {
    // $temp = ($sql->fetch_assoc())['duration'];
    return ($sql->fetch_assoc())['description'];
    // return "$temp";
  } else {
    return "it". addslashes("'") ."s a mystery~";
  }
}

function getAttractions($trip_id) {
  $str = "<p style=". addslashes("'") . "margin-left: 1px; font-size: 14px; color: #333333;". addslashes("'") . ">&#x2731; Attractions:";

  global $conn;
  $sql = "SELECT attr_name, location_id FROM IncludesAttraction WHERE trip_id = $trip_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
    $str = $str . "<br>&gt; ".$row['attr_name']."<br>";
    $str = aboutAttraction($row['attr_name'], $row['location_id'], $str);
  }
  $str = $str . "</p>";
  return $str;
}

function aboutAttraction($attr_name, $location_id, $acc) {
  global $conn;
  $sql = "SELECT type, description, num_dollar_signs FROM Attraction_In WHERE attr_name='$attr_name' AND location_id='$location_id'";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  if (isset($row['type'])) {
    $acc = $acc . "&nbsp;&nbsp;&nbsp;type: ".$row['type']."<br>";
  }
  if (isset($row['description'])) {
    $acc = $acc . "&nbsp;&nbsp;&nbsp;description: ".$row['description']."<br>";
  }
  if (isset($row['num_dollar_signs'])) {
    switch ($row['num_dollar_signs']) {
      case 0:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: FREE";
        break;
      case 1:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $";
        break;
      case 2:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $$";
        break;
      case 3:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $$$";
        break;
      default:
        break;
    }
  }
  // $acc = $acc. "<br>";
  return $acc;
}

function getActivities($trip_id) {
  $str = "<p style=". addslashes("'")
        . "margin-left: 1px; font-size: 14px; color: #333333;". addslashes("'")
        . ">&#x2731; Activities: ";

  global $conn;
  $sql = "SELECT activity_name FROM IncludesActivity WHERE trip_id = $trip_id";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))  {
    $str = $str . "<br>&gt; " .$row['activity_name']."<br>";
    $str = aboutActivity($row['activity_name'], $str);
  }
  /* $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  if (isset($row['activity_name'])) {
    $str = $str . $row['activity_name']; 
    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))  {
      $str = $str . ", ".$row['activity_name'];
    }
  } else {
    $str = $str . "none";
  } */

  $str = $str . "</p>";
  return $str;
}

function aboutActivity($aname, $acc) {
  global $conn;
  $sql = "SELECT type, description, num_dollar_signs
          FROM Activity A
          WHERE name='$aname'";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  if (isset($row['type'])) {
    $acc = $acc . "&nbsp;&nbsp;&nbsp;type: ".$row['type']."<br>";
  }
  if (isset($row['description'])) {
    $acc = $acc . "&nbsp;&nbsp;&nbsp;description: ".$row['description']."<br>";
  }
  if (isset($row['num_dollar_signs'])) {
    switch ($row['num_dollar_signs']) {
      case 0:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: FREE";
        break;
      case 1:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $";
        break;
      case 2:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $$";
        break;
      case 3:
        $acc = $acc . "&nbsp;&nbsp;&nbsp;price: $$$";
        break;
      default:
        break;
    }
  }
  // $acc = $acc. "<br>";
  return $acc;
}

function getRestaurants($trip_id) {
  $str = "<p style=". addslashes("'")
        . "margin-left: 1px; font-size: 14px; color: #333333;". addslashes("'")
        . ">&#x2731; Restaurants: ";
  global $conn;
  $sql = "SELECT * FROM Restaurant WHERE name IN (SELECT restaurant_name FROM IncludesRestaurant WHERE trip_id = $trip_id)";
  $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
    // if (isset($row['name'])) {
    $str = $str . "<br>&gt; " .$row['name']."<br>";
    // }
    if (isset($row['cuisine_type'])) {
      $str = $str . "&nbsp;&nbsp;&nbsp;cuisine type: ".$row['cuisine_type']."<br>";
    }
  
    if (isset($row['num_dollar_signs'])) {
      switch ($row['num_dollar_signs']) {
        case 1:
          $str = $str . "&nbsp;&nbsp;&nbsp;price: $";
          break;
        case 2:
          $str = $str . "&nbsp;&nbsp;&nbsp;price: $$";
          break;
        case 3:
          $str = $str . "&nbsp;&nbsp;&nbsp;price: $$$";
          break;
        
        default:
          break;
      }
    }
  }

  return $str;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wanderlist | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,400;0,500;0,700;0,800;1,800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->
    <link href="./bootstrap/css/templates/dashboard.css" rel="stylesheet">
    <link href="./bootstrap/css/templates/offcanvas.css" rel="stylesheet">
    <link href="./bootstrap/css/myappendix.css" rel="stylesheet">

    <style>
		  * {
        font-family: 'Muli', sans-serif;
        }

      #current-user {
        position: absolute;
        top: 280px;
        /* margin-bottom: 30px; */
        left: 100px;
        
        /* margin-bottom: 100px; */
      }

      a:link {
        color: #6A57B0;
      }

      a:visited {
        color: #6A57B0;
      }
      
      a:hover {
        color: #4A3D79;
      }

      #current-user-link {
        font-size: 30px;
        display: block;
        font-weight: bold;
        font-style: italic;
        color: #4A3D79;
      }

      #current-user-link:hover {
        color: #6A57B0;
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

      .mini-btn {
        background-color: #E9E3FF;
        color: #4A3D79;
        border: 2px solid #4A3D79;
        border-radius: 30px;
        transition-duration: 0.3s;
      }

      .mini-btn:hover {
        background-color: #4A3D79;
        color: white;
      }

      #show-plan {
        /* text-align: center; */
      }
      
      .pplan {
        
      }
      /* overwrite bootstrap css (myappendix.css) */
      p.post-caption {
        padding-top: 5px;
        /* padding-bottom: 5px; */
        font-size: 18px;
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
      .header { 
            /* this somehow works as a sticky header idek what i did */
            width: 100%;
            height: 50px;
            position: fixed;
            top: 0;
            left: 0;
            background: #e9e4fe;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .2s ease;
            background-color: rgba(255, 255, 255, 0);
        }

        .header:hover .overlay {
            opacity: 1;
        }

        #btn_home2 {
            cursor: pointer;
            max-height: 55px; 
            width: auto;
            height: auto;
            vertical-align: middle;
            padding-top: 2px;
            padding-left: 12px;
            padding-bottom: 7px;
        }

        #plan-overlay {
          position: fixed;
          overflow-y: scroll; 
          display: none;
          width: 200px;
          height: 400px;
          left: 90%;
          top: 55%;
          transform: translate(-50%, -50%);
          /* background: rgba(194, 186, 220, 0.8); */
          background: #E9E3FF;
          /* border: 4px solid #4A3F78; */
          border: 3px solid #4A3D79;
          box-sizing: border-box;
          box-shadow: -3px 3px 3px rgba(0, 0, 0, 0.25);
          border-radius: 1px;
          z-index: 2;
          cursor: pointer;
        }
      
    </style>
    <script>
        function goHome() {
            window.location = "index.php";
        }

        function on(str) {
            document.getElementById("plan").innerHTML = "<br>" + str + "<br>Click on me to exit.<br><br>";
            document.getElementById("plan-overlay").style.display = "block";
        }

        function off() {
            document.getElementById("plan-overlay").style.display = "none";
        }
    </script>
  </head>

  <body>
  <div id="plan-overlay" onclick="off()">
      <div style="overflow-y:scroll;" id="plan"></div>
  </div>
  <!-- search bar -->
	<div class="bar-container col-md-offset-3">
		<form action="searchbar-parser.php" method="get">
      <input size="100" name="query" class="search" placeholder="Search by tag, user, etc.">
		</form>
  </div>

    <!-- side navigation bar -->
    <div class="container-fluid">
      <div class="col-md-3 post-sidebar">
        <div class="header">
          <img id="btn_home" src="images/webpage/origami.png" onclick="goHome()" width="100" height="100">
          <div class="overlay">
              <img src="images/webpage/dinosoar.png" onclick="goHome()" alt="fly home!" id="btn_home2">
          </div>
        </div>
        <div class="placeholder">
          <?php getPfp() ?>
        </div>
        <div id="current-user">
        <br>
          <a id="current-user-link" href='searchbar-parser.php?query=<?php echo $_SESSION["username"]?>' class='post-tag' style='margin-left:18px;'><?php echo $_SESSION["username"]?></a>
        </div>
        <br>
          <!-- buttons -->
        <div>
          <br>
          <br>
          <button class="side-post-button" onclick="document.location='create.php'">Create Post</button>
          <br>
          <?php settingsButton(); ?>
          <br>
          <button class="side-post-button" onclick="document.location='logout.php'">Log Out</button>
        </div>
      </div>
    </div>

  <!-- main section -->
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-3 main">
    <!-- checkbox -->
    <div class="row" >
      <form action="index.php" method="get">
        Toggle View:
        &nbsp;
        <label for="country">
        <input type="checkbox" name="country"> country 
        </label>
        &nbsp;
        <label for="province">
        <input type="checkbox" name="province"> province 
        </label>
        &nbsp;
        <label for="city">
        <input type="checkbox" name="city"> city 
        </label>
        &nbsp;
        <input class="mini-btn" type="submit" name="filter_submit" value="filter">
      </form>
    </div>

    <!-- posts -->
    <?php 
    if (isset($_GET['search']) && $_GET['search'] == "true") { // show search result
      loadPosts("Subposts");
    } else { // normal view
      loadPosts("Trip_in");
    }
    ?>
  </div>/
    
  </body>
</html>
