<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-md">
        <a class="navbar-brand" href="http://localhost/">IMGUR Clone</a>
    </div>

    <?php
    $uri = $_SERVER['REQUEST_URI'];

    if (isset($_SESSION['user_id'])) {

        if ($uri == '/users/profile/' . $_SESSION['user_id']) {
            echo '
                        <div class="p-2">
                            <a class="btn btn-success btn-lg" href="' . HOME_URL . '">Home</a>
                        </div>';
        } else {
            echo '
                <div class="p-2">
                    <a class="btn btn-success btn-lg" href="' . PROFILE_URL . '">Profile</a>
                </div>
                ';
        }

        echo '
                <div class="p-2">
                    <a class="btn btn-success btn-lg" href="' . LOGOUT_URL . '">Logout</a>
                </div>';
    } else {

        switch ($uri) {
            case '/users/login':
                echo '
                    <div class="p-2">
                        <a class="btn btn-success btn-lg" href="' . HOME_URL . '">Home</a>
                    </div>
                    <div class="p-2">
                        <a class="btn btn-success btn-lg" href="' . REGISTER_URL . '">Register</a>
                    </div>';
                break;
            case '/users/register':
                echo '
                    <div class="p-2">
                        <a class="btn btn-success btn-lg" href="' . HOME_URL . '">Home</a>
                    </div>
                    <div class="p-2">
                        <a class="btn btn-success btn-lg" href="' . LOGIN_URL . '">Login</a>
                    </div>';
                break;
            default:
                echo '<div class="p-2">
                    <a class="btn btn-success btn-lg" href="' . LOGIN_URL . '">Login</a>
                  </div>
                  <div class="p-2">
                    <a class="btn btn-success btn-lg" href="' . REGISTER_URL . '">Register</a>
                  </div>';
        }
    }
    ?>


</nav>
