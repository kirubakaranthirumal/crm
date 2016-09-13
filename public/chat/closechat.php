<?php
session_start();
error_reporting(0);
unlink("loghtml/log.".$_SESSION['chatfilename'].".html");
unset($_SESSION['chatfilename']);
echo "closed";
?>