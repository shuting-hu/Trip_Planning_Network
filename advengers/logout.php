<?php
// clear session, redirect to login
if (isset($_GET['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("location: login.html");
}
