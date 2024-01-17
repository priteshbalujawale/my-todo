<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Login-todo</title>
</head>

<body>
    <?php include('partials/_dbConnection.php') ?>
    <?php include('partials/_signup.php') ?>
    <?php include('partials/_login.php') ?>
    <?php include('partials/_header.php') ?>
    <?php session_start();
    $user_id;
    if (isset($_SESSION['username']) && $_SESSION['loggedin'] == true) {
        $user_id = $_SESSION['userid'];
        header("Location:/php_tutorials/php-projects/todo/");
        exit();
    }
    ?>
    <section class="my-5" style="min-height:450px">
        <?php
        // display error
        // $get_Method = $_SERVER['REQUEST-METHOD'] == 'GET';
        $dispMessage = '';
        $alert = '';
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            // echo $message;
            if ($message == 'acCreated') {
                $dispMessage = 'Your account is created successfully please login to continue';
                $alert = 'success';
            }
            if ($message == 'userExist') {
                $dispMessage = 'User already exist please login to continue';
                $alert = 'warning';
            }
            if ($message == 'passwordMatcherr') {
                $dispMessage = 'Your confirm password do not match please try again';
                $alert = 'warning';
            }
            if ($message == 'nouser') {
                $dispMessage = 'No user found please create account to continue';
                $alert = 'warning';
            }
            if ($message == 'invalidcredentials') {
                $dispMessage = 'Invalid email address or password try with valid credentials';
                $alert = 'warning';
            }
            if ($message == 'pleaselogin') {
                // echo $message;
                $alert = 'warning';
                $dispMessage = 'Your not loggedin please plgin to continue';
            }
            echo '
            <div class="alert alert-' . $alert . ' alert-dismissible fade show container" role="alert">
            ' . $dispMessage . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }

        ?>
        <div class="container">
            <div class="d-block login-container">
                <div class="row d-flex justify-content-center align-items-center" style="display: block;">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="img.png" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form action="" method="POST">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="loginEmail">Email address</label>
                                <input type="email" id="loginEmail" name="loginEmail" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <label class="form-label" for="loginPassword">Password</label>
                                <input type="password" id="loginPassword" name="loginPassword" class="form-control form-control-lg" placeholder="Enter password" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#!" class="text-body">Forgot password?</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#" class="link-danger" id="register">Register</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="d-none login-container">
                <div class="row d-flex justify-content-center align-items-center active-visible">
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form action="" method="POST">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="r_username">User Name</label>
                                <input type="text" id="r_username" name="r_username" class="form-control form-control-lg" required />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="r_email">Email address</label>
                                <input type="email" id="r_email" name="r_email" class="form-control form-control-lg" placeholder="Enter a valid email address" required />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <label class="form-label" for="r_password">Password</label>
                                <input type="password" id="r_password" name="r_password" class="form-control form-control-lg" placeholder="Enter password" required />
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="r_cpassword">Confirm Password</label>
                                <input type="password" id="r_cpassword" name="r_cpassword" class="form-control form-control-lg" placeholder="Enter password" required />
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Sign Up</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Have an account? <a href="#" class="link-danger" id="login">Login</a></p>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="img.png" class="img-fluid" alt="Sample image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('partials/_footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script>
        $('#login').on('click', function(e) {
            $(this).closest('.login-container').removeClass('d-block').addClass('d-none');
            $('#register').closest('.login-container').removeClass('d-none').addClass('d-block');
        })
        $('#register').on('click', function(e) {
            $(this).closest('.login-container').removeClass('d-block').addClass('d-none');;
            $('#login').closest('.login-container').addClass('d-block').removeClass('d-none');;

        })
    </script>
</body>

</html>