<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootsrap css -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        @media(max-width:786px) {
            a.list-group-item.list-group-item-action.m-3.rounded.border-0.shadow-lg.col-5 {
                width: 100%;
                max-width: none !important;
                flex: auto !important;
            }
        }
    </style>
    <title>ToDo</title>
</head>

<body style="background-color:#f8f9fa">
    <?php include('partials/_dbConnection.php') ?>
    <?php
    // <!-- inserting title and description into tabel -->
    session_start();
    $user_id;
    if (isset($_SESSION['username']) && $_SESSION['loggedin'] == true) {
        $user_id = $_SESSION['userid'];
    } else {
        header("Location:login.php?message=pleaselogin");
        exit();
    }
    $post_method = $_SERVER['REQUEST_METHOD'] == 'POST';
    $get_method = $_SERVER['REQUEST_METHOD'] == 'GET';
    if ($post_method) {
        if (isset($_POST['inputTitle']) && isset($_POST['inputDescription'])) {
            $title = $_POST['inputTitle'];
            $description = $_POST['inputDescription'];
            $user = $user_id;
            echo $user;
            $query = "INSERT INTO `todolist` (`title`, `description`, `date`, `user`) VALUES ('$title', '$description', current_timestamp(), '$user')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("Location:?message=inserted");
                // echo "data inserted succesfully";
                exit();
            } else {
                header("Location:?message=error");
                exit();
            }
        } else
        if (isset($_POST['updateTitle']) && isset($_POST['updateDescription']) && isset($_POST['updateId'])) {
            $update_title = $_POST['updateTitle'];
            $update_description = $_POST['updateDescription'];
            $update_id = $_POST['updateId'];
            // echo $update_title . "<br/> " . $update_description . "<br/> " . $update_id . "<br/> ";
            $updateQuery = "UPDATE `todolist` SET `title` = '$update_title', `description` = '$update_description' WHERE `todolist`.`Srn` = $update_id";
            $updateResult = mysqli_query($conn, $updateQuery);
            if ($updateResult) {
                header("Location:?message=updated");
                exit();
            } else {
                header("Location:?message=error");
                exit();
                // echo mysqli_error($conn);
                // echo $update_title;
            }
        } else {
            echo "somthing went wrong";
        }
    }
    if ($get_method) {
        if (isset($_GET['delete'])) {
            $srn = $_GET['delete'];
            $deleteQuery = "DELETE FROM .`todolist` WHERE `todolist`.`Srn` ='$srn' ;";
            $deleteResult = mysqli_query($conn, $deleteQuery);
            if ($deleteResult) {
                header("Location:?deleted");
            } else {
                echo mysqli_error($conn);
            }
        }
    }
    ?>

    <header>
        <?php include('partials/_header.php') ?>
    </header>
    <main class="position-relative" style="min-height:450px">
        <?php
        // display error
        // $get_Method = $_SERVER['REQUEST-METHOD'] == 'GET';
        $dispMessage = '';
        $alert = '';
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            // echo $message;
            if ($message == 'updated') {
                $dispMessage = 'Your list is updated successfully';
                $alert = 'success';
            }
            if ($message == 'inserted') {
                $dispMessage = 'Your values are inserted successfully';
                $alert = 'success';
            }
            if ($message == 'error') {
                $dispMessage = 'There is some error while updating please try after some time';
                $alert = 'danger';
            }
            if ($message == 'deleted') {
                $dispMessage = 'Item is deleted successfully';
                $alert = 'warning';
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
        <h1 class="text-center my-3">To Do List</h1>
        <div class="list-group container row m-auto align-items-center justify-content-center flex-row p-0">
            <?php
            $user = $user_id;
            $getQuery = "SELECT * FROM `todolist` WHERE `user`='$user'";
            $getQueryResult = mysqli_query($conn, $getQuery);
            $num = mysqli_num_rows($getQueryResult);
            if ($num > 0) {
                // echo "inside if " . $num;
                while ($row = mysqli_fetch_assoc($getQueryResult)) {
                    // echo "inside while";
                    $showTime = $row['date'];
                    $dateTimeString = $row['date'];
                    $dateTimeObject = new DateTime($dateTimeString);
                    $formattedDate = $dateTimeObject->format('Y-m-d');
                    $today = new DateTime();
                    $todayFormatted = $today->format('Y-m-d');
                    $daysDifference = $today->diff($dateTimeObject)->days;

                    if ($daysDifference == 0) {
                        $showTime = 'today';
                    } else {
                        $showTime = $daysDifference . " days ago";
                    }


                    echo '
                    <a class="list-group-item list-group-item-action m-3 rounded border-0 shadow-lg col-5" id="' . $row['Srn'] . '">
                    <div class="d-flex w-100 justify-content-between">
                        <h2 class="mb-1 list-title">' . $row['title'] . '</h2>
                        <small>' .  $showTime . '</small>
                    </div>
                    <p class="mb-1 list-description">' . $row['description'] . '</p>
                    <div><small>And some small print.</small></div>
                    <div class="btn-group my-2">
                        <button type="button" class="btn btn-primary btn-sm p-1 update-list" data-toggle="modal" data-target="#updatTodoList">Update</button>
                        <button type="button" class="btn btn-danger btn-sm p-1 mx-1 delete-list" id="' . $row['Srn'] . '">Delete</button>
                    </div>

                </a>';
                }
            } else {
                echo "<div class='text-center'>No data found<div/>";
            }
            ?>
            <a href="#" class="list-group-item list-group-item-action m-3 rounded border-0 shadow-0 col-5 bg-transparent text-center" data-toggle="modal" data-target="#todolistForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#676767" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
            </a>
        </div>
        <!--list form -->

        <div class="modal fade" id="todolistForm" tabindex="-1" aria-labelledby="todolistForm" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Add into list</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text" class="form-control" id="inputTitle" aria-describedby="inputTitle" name="inputTitle" required maxlength=300>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea class="form-control" id="inputDescription" name="inputDescription" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- update form -->
        <!-- Modal -->
        <div class="modal fade" id="updatTodoList" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Update List</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <input type="hidden" name="updateId" id="updateId">
                            <div class="form-group">
                                <label for="updateTitle">Title</label>
                                <input type="text" class="form-control" id="updateTitle" aria-describedby="updateTitle" name="updateTitle" required maxlength=300>
                            </div>
                            <div class="form-group">
                                <label for="updateDescription">Description</label>
                                <textarea class="form-control" id="updateDescription" name="updateDescription" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include('partials/_footer.php') ?>
    </footer>
    <!-- bootsrap js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(".update-list").on("click", function() {
            const parentElement = $(this).closest('.list-group-item');
            const parentElementId = parentElement[0].id;
            const title = parentElement.find('h2').text();
            const description = parentElement.find('.list-description').text();
            $('#updateTitle').val(title);
            $('#updateDescription').val(description);
            // console.log(parentElementId);
            $('#updateId').val(parentElementId);

        });

        $(".delete-list").on('click', function(e) {
            const btn = e.target.id;
            const confirm = window.confirm(`are you really want to delete this`)
            if (confirm) {
                window.location = `?delete=${btn}`;
            }
        });
    </script>
</body>

</html>