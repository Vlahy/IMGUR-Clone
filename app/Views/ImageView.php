<?php

include HEADER;
include NAVIGATION;
if (isset($data) && $data != false) {
    echo '<div class="container">';
    echo '<div class="row">';

    echo '<div class="col d-flex align-items-center justify-content-center mt-5">
            <div class="card" style="width: 340px">
            <img class="card-image-top mx-2 my-2"
             src="' . $data['file_name'] . '?random=' . $data['id'] . '"
              alt="' . $data['slug'] . '">';

    if (isset($_SESSION['user_id'])) {
        echo '<div class="card-body">';
        if ($_SESSION['user_id'] == $data['user_id']) {
            echo '<form class="d-inline" action="http://localhost/users/image/delete/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-danger">Delete</button></form>';
        }
        if ($_SESSION['user_id'] == $data['user_id'] || $_SESSION['role'] == 'admin'){
            echo '<button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>';
        }
        if ($_SESSION['role'] == 'moderator' || $_SESSION['role'] == 'admin') {
            echo '<form class="d-inline" action="http://localhost/users/image/nsfw/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">NSFW</button></form>';
            echo '<form class="d-inline" action="http://localhost/users/image/hidden/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">Hidden</button></form>';
        }
        echo '</div>';
    }

    echo '</div></div></div></div>';
}

?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="http://localhost/users/image/update/">
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                        <label for="slug" class="form-label">Slug</label>
                        <input id="slug" name="slug" type="text" class="form-control"
                               value="<?php echo $data['slug'] ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="submit" type="submit" value="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<?php
include FOOTER;
