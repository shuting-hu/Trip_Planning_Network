<?php
// clear cookies
session_start();
session_unset();
session_destroy();
// back to login page
header("location:login.html");
?> 