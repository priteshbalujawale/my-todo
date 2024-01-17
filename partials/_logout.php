<?php
session_start();
session_unset();
session_destroy();
header("Location:/php_tutorials/php-projects/todo/login.php");
