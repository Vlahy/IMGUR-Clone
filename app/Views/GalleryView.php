<?php

include HEADER;
include NAVIGATION;


if (isset($data) && $data != false && $data['info'] != null) {
    $counter = 0;
    $result = $data['info'][0];
    echo '<div class="container">';
    echo '<h1 class="mt-3 mb-3 lead display-4">Images <small class="text-muted">List</small></h1>';


    echo '<div class="row">
            <div class="col-sm-8 mt-4">
            <div class="card-body">
            <h2>' . $result["name"] . '</h2>
            <p>' . $result["description"] . '</p>
            </div>
            </div>
            <div class="col-sm-4 mt-4 align-items-center">
            <div class="card-body">';
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == $result['user_id']) {
            echo '<form class="d-inline" action="http://localhost/users/gallery/delete/' . $result["id"] . '" method="post">
            <button type="submit" class="btn btn-danger">Delete</button></form>';
        }
        if ($_SESSION['user_id'] == $result['user_id'] || $_SESSION['role'] == 'admin') {
            echo '<button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>';
        }
    }
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'moderator' || $_SESSION['role'] == 'admin') {
            echo '<form class="d-inline" action="http://localhost/users/gallery/nsfw/' . $result['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">NSFW</button></form>';
            echo '<form class="d-inline" action="http://localhost/users/gallery/hidden/' . $result['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">Hidden</button></form>';
        }
    }
    echo '</div>
            </div>
            
            
            <hr />';
    echo '<div class="row row-cols-3 g-4">';
    foreach ($data['gallery'] as $value) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $value->user_id) {
            if ($value->nsfw == 0 || $value->hidden == 0) {
                echo '<div class="col-sm-4 align-items-center"><div class="card" style="width: 340px"><a href="http://localhost/users/image/' . $value->id .
                    '"><img class="card-image-top mx-2 my-2"
             src="' . $value->file_name . '?random=' . $value->id . '"
              alt="' . $value->slug . '"></a>
              
              </div>
              </div>';
            }
        } else {
            echo '<div class="col-sm-4 d-flex align-items-center justify-content-center"><div class="card" style="width: 340px"><a href="http://localhost/users/image/' . $value->id .
                '"><img class="card-image-top m-2"
             src="' . $value->file_name . '?random=' . $value->id . '"
              alt="' . $value->slug . '"></a>
              </div>
              </div>';
        }
        $counter++;
    }
    echo '</div>';

    $page = $_GET['page'] ?? 1;
    echo '<div class="row align-items-center justify-content-around">';
    if ($page <= 1) {
        $disabled = "disabled";
    } else {
        $disabled = '';
    }
    echo '<div class="col"><a class="btn btn-outline-primary m-4 ' . $disabled . '" href="?page=' . ($page - 1) . '">Previous Page</a></div>';
    if ($counter < 10) {
        $disable = "disabled";
    } else {
        $disable = '';
    }
    echo '<div class="col"><a class="btn btn-outline-primary m-4 float-end' . $disable . '" role="button" href="?page=' . ($page + 1) . '">Next Page</a></div>';

    echo '</div>';
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
                    <form class="form" method="post" action="http://localhost/users/gallery/update/">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                        <label for="name" class="form-label">Title</label>
                        <input id="name" name="name" type="text" class="form-control"
                               value="<?php echo $result['name'] ?>">
                        <label for="description" class="form-label">Description</label>
                        <textarea rows="10" name="description" id="description" type="text"
                                  class="form-control"><?php echo $result['description'] ?></textarea>
                </div>
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
