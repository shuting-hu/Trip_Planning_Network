<?php
session_start();

/* SOURCE: https://segmentfault.com/a/1190000015750653 */
$upfile=$_FILES["pic"];
$typelist=array("image/jpeg","image/jpg","image/png","image/gif");
$path="./images/";

if($upfile["error"]>0){
    die("error");
}
if(!in_array($upfile["type"],$typelist)){
    die("Invalid data type: ".$upfile["type"]);
}
 
// randomly generate a file name
$fileinfo=pathinfo($upfile["name"]);
do{ 
    $newfile=date("YmdHis").rand(1000,9999).".".$fileinfo["extension"];
}while(file_exists($path.$newfile));

if(is_uploaded_file($upfile["tmp_name"])){
    if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
        include'connect.php';
        $conn = OpenCon();
        $type = $_GET['type'];
        $sql = "";
        if ($type == "post") { // upload post image
            $toMedia = "INSERT INTO Media(date, type) VALUES (now(), 2);";
            $toPhoto = "INSERT INTO Photo(post_id, file_path) VALUES (LAST_INSERT_ID(), '$path$newfile')";
            $sql = $toMedia.$toPhoto;
        } else if ($type == "pfp") { // upload pfp
            $username = $_SESSION["username"];
            $sql = "INSERT INTO Regular_user VALUES ('$username', '$path$newfile')";
        }
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        // check result?
    }
}
?>