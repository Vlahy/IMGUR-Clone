<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-md">
        <a class="navbar-brand" href="http://localhost/">IMGUR Clone</a>
    </div>

    <?php
    $uri = $_SERVER['REQUEST_URI'];

    if (isset($_SESSION['user_id'])) {

        echo '<div class="p-2"><button class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addGalleryModal">Add Gallery</button></div>';

        if ($uri == '/users/profile/' . $_SESSION['user_id']) {
            echo '
                        <div class="p-2">
                            <a class="btn btn-outline-success btn-lg" href="' . HOME_URL . '">Home</a>
                        </div>';
        } else {
            echo '
                <div class="p-2">
                    <a class="btn btn-outline-success btn-lg" href="' . PROFILE_URL . '">Profile</a>
                </div>
                ';
        }

        echo '
                <div class="p-2">
                    <a class="btn btn-outline-success btn-lg" href="' . LOGOUT_URL . '">Logout</a>
                </div>';
    } else {

        switch ($uri) {
            case '/users/login':
                echo '
                    <div class="p-2">
                        <a class="btn btn-outline-success btn-lg" href="' . HOME_URL . '">Home</a>
                    </div>
                    <div class="p-2">
                        <a class="btn btn-outline-success btn-lg" href="' . REGISTER_URL . '">Register</a>
                    </div>';
                break;
            case '/users/register':
                echo '
                    <div class="p-2">
                        <a class="btn btn-outline-success btn-lg" href="' . HOME_URL . '">Home</a>
                    </div>
                    <div class="p-2">
                        <a class="btn btn-outline-success btn-lg" href="' . LOGIN_URL . '">Login</a>
                    </div>';
                break;
            default:
                echo '<div class="p-2">
                    <a class="btn btn-outline-success btn-lg" href="' . LOGIN_URL . '">Login</a>
                  </div>
                  <div class="p-2">
                    <a class="btn btn-outline-success btn-lg" href="' . REGISTER_URL . '">Register</a>
                  </div>';
        }
    }
    ?>

</nav>


<!-- Modal for adding gallery-->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="http://localhost/users/gallery/add">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" name="name" type="text" class="form-control" required>
                    <label for="description" class="form-label">Description</label>
                    <input name="description" id="description" type="text" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="submit" type="submit" value="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


