<?php

$post_method = $_SERVER['REQUEST_METHOD'] == 'POST';

if ($post_method) {
    if (isset($_POST['r_email']) &&  isset($_POST['r_password'])) {
        $r_password = $_POST['r_password'];
        $r_cpassword = $_POST['r_cpassword'];
        $r_email = $_POST['r_email'];
        $r_username = $_POST['r_username'];
        $userExist = "SELECT * FROM `user` WHERE `email`='$r_email'";
        $userExistResult = mysqli_query($conn, $userExist);
        $numRows = mysqli_num_rows($userExistResult);
        if ($numRows > 0) {
            header("Location:?message=userExist");
            exit();
        } else {
            if ($r_cpassword === $r_password) {
                $hash = password_hash($r_password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO `user` (`username`, `email`, `password`) VALUES ('$r_username', '$r_email', '$hash')";
                $insertResult = mysqli_query($conn, $insertQuery);
                if ($insertResult) {
                    header("Location:?message=acCreated");
                    exit();
                } else {
                    // header("Location:?message=passwordMatch");
                    echo mysqli_error($conn);
                    exit();
                }
            } else {
                header("Location:?message=passwordMatcherr");
                exit();
            }
        }
    }
}
