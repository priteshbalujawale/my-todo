<div class="container-fluid bg-primary">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary container text-light">
        <a class="navbar-brand" href="/localhost/php_tutorials/php-projects/todo">My-todo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/php_tutorials/php-projects/todo">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/php_tutorials/php-projects/todo/">About</a>
                </li>
            </ul>
            <div class="btn-group">
                <?php
                if (isset($_SESSION['username']) && $_SESSION['loggedin'] == true) {
                    echo '<span class="my-2">Welcome ' . $_SESSION['username'] . '</span>';
                    echo '<a href="/php_tutorials/php-projects/todo/partials/_logout.php" class="btn btn-primary mx-1">Logout</a>';
                }
                ?>

            </div>
        </div>
    </nav>
</div>