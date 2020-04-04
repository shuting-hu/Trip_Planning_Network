<html>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="newpfp">
        <input type="submit" value="Upload new profile picture" name="submit">
    </form>
</html>
<?php

// TODO: file directory permissions
// TODO: dynamic user

include 'connect.php';

if (isset($_POST["submit"])) {
    $conn = OpenCon();

    $user = 'test';
    $target_dir = "images/pfp/";
    $pfppath = $target_dir;

    $target_file = $target_dir . basename($_FILES["newpfp"]["name"]);
    echo nl2br("TARGET IS: $target_file\n");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
    // Check if image file is a actual image or fake image
    if (empty($_FILES["newpfp"]["tmp_name"])) {
        echo "exiting, no image provided";
    }

    $check = getimagesize($_FILES["newpfp"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    $newname = $pfppath . $user . "." . $imageFileType;

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        $oldpfp = mysqli_query($conn, "SELECT profile_picture AS pfp
                                        FROM Regular_User
                                        WHERE username = '$user'
                                        AND profile_picture IS NOT NULL") or die(mysqli_error($conn));
        if (mysqli_num_rows($oldpfp) > 0) {
            unlink(($oldpfp->fetch_assoc())['pfp']);
        }

        if (move_uploaded_file($_FILES["newpfp"]["tmp_name"], $newname)) {//$target_file)) {
            echo "The file ". basename( $_FILES["newpfp"]["name"]). " has been uploaded.";

            $updatepfp = mysqli_query($conn, "UPDATE Regular_User SET profile_picture = '$newname' WHERE username = '$user'") or die(mysqli_error($conn));
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
}
?>