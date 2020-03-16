<?php
$username = $_POST['username'];
$pwd = $_POST['password'];
echo nl2br("Attempted login with...\nusername: $username\npassword: $pwd\n");
if ($username == 'abc' && $pwd == '123') {
    echo nl2br("\nLogin successful.");
    header("Location: http://localhost/304proj/index.html");
    exit();
} else {
    echo nl2br("\nLogin failed.");
}
?>