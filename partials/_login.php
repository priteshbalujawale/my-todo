<?php
include('partials/_dbConnection.php');
$postMethod = $_SERVER['REQUEST_METHOD'] == 'POST';
if ($postMethod) {
    if (isset($_POST['loginEmail']) &&  isset($_POST['loginPassword'])) {
        $loginEmail = $_POST['loginEmail'];
        $loginPassword = $_POST['loginPassword'];
        $loginQuery = "SELECT * FROM `user` WHERE `email`='$loginEmail'";
        $loginResult = mysqli_query($conn, $loginQuery);
        $num = mysqli_num_rows($loginResult);
        // var_dump($result);
        if ($num === 1) {
            while ($row = mysqli_fetch_assoc($loginResult)) {
                if (password_verify($loginPassword, $row['password'])) {
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['userid'] = $row['userid'];
                    header("Location:/php_tutorials/php-projects/todo");
                    // echo $row['userid'];

                    // echo "sucess";
                    // echo $result;
                    exit();
                } else {
                    header("Location:?message=invalidcredentials");
                    exit();
                }
            }
        } else {
            header("Location:?message=nouser");
            exit();
            // echo "sucess";
        }
    }
}
