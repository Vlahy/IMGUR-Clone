<?php

include HEADER;
include NAVIGATION;


if (isset($data) && $data != false && $data['info'] != null) {
    $counter = 0;
    $info = $data['info'][0];
    echo '<div class="container">';
    echo '<h1 class="mt-3 mb-3 lead display-4">Images <small class="text-muted">List</small></h1>';


    echo '<div class="row">
            <div class="col-sm-8 mt-4">
            <div class="card-body">
            <h2>' . $info["name"] . '</h2>
            <p>' . $info["description"] . '</p>
            </div>
            </div>
            <div class="col-sm-4 mt-4 align-items-center">
            <div class="card-body">';
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == $info['user_id']) {
            echo '<form class="d-inline" action="http://localhost/users/gallery/delete/' . $info["id"] . '" method="post">
            <button type="submit" class="btn btn-outline-danger">Delete</button></form>';
            echo '
<button class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#addImageModal">Add Image</button>
<!-- Modal for adding image -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" name="upload" class="form" method="post" action="http://localhost/users/image/add">
                    <input type="hidden" name="user_id" value="' . $info['user_id'] . '">
                    <input type="hidden" name="gallery_id" value="' . $info['id'] . '">
                    <label for="image" class="form-label">Select image: </label>
                    <input type="file" name="image" accept="image/jpeg, image/png, image/jpg, image/gif">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="submit" type="submit" name="upload" value="submit" class="btn btn-primary">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>';
        }
        if ($_SESSION['user_id'] == $info['user_id'] || $_SESSION['role'] == 'admin') {
            echo '<button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>';
        }
    }
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'moderator' || $_SESSION['role'] == 'admin') {
            echo '<form class="d-inline" action="http://localhost/users/gallery/nsfw/' . $info['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">NSFW</button></form>';
            echo '<form class="d-inline" action="http://localhost/users/gallery/hidden/' . $info['id'] . '" method="post">
                <button type="submit" class="btn btn-outline-success">Hidden</button></form>';
        }
    }
    echo '</div>
            </div>
            
            
            <hr />';
    echo '<div class="row row-cols-3 g-4">';
    foreach ($data['gallery'] as $value) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $value->user_id) {
            if ($value->nsfw == 0 && $value->hidden == 0) {
                echo '<div class="col-sm-4 align-items-center"><div class="card" style="width: 340px"><a href="http://localhost/users/image/' . $value->slug .
                    '"><img class="card-image-top mx-2 my-2"
             src="/images/' . $value->file_name . '"
              alt="' . $value->slug . '"></a>
              
              </div>
              </div>';
            }
        } else {
            echo '<div class="col-sm-4 d-flex align-items-center justify-content-center"><div class="card" style="width: 340px"><a href="http://localhost/users/image/' . $value->slug .
                '"><img class="card-image-top m-2" style="width: 320px; height: 240px"
             src="/images/' . $value->file_name . '"
              alt="' . $value->slug . '"></a>
              </div>
              </div>';
        }
        $counter++;
    }

    echo '</div>';

    include PAGE_NAVIGATION;


    if (isset($_SESSION['user_id'])) {
        echo '  
                <div class="row align-items-center justify-content-center mb-5">
                <div class="col-6">
                <div class="card">
                <form class="card-body" method="post" action="http://localhost/users/gallery/comment">
                        <input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">
                        <input type="hidden" name="gallery_id" value="' . $info['id'] . '">
                        <label for="comment" class="form-label"></label>
                        <textarea rows="3" id="comment" name="comment" type="text" class="form-control"
                               placeholder="Type your comment here..."></textarea>
                    <button id="submit" type="submit" value="submit" class="btn btn-outline-primary mt-2">Add Comment</button>
                </form>
                </div>
                </div>
                </div>';
    }
    if (isset($data['comment'])) {
        if ($data['comment'] == null) {
            $comments[] = [
                'username' => '',
                'comment' => 'Comments do not exist!',
            ];
        } else {
            $comments = $data['comment'];
        }
        echo '<div class="row align-items-center justify-content-center mb-5">
                <div class="col-6">
                <div class="card">
                <h4 class="card-header">Comments</h4>
                <div class="card-body">';
        foreach ($comments as $comment) {
            echo '<h5 class="card-title">' . $comment["username"] . '</h5>
                    <p class="card-text">' . $comment["comment"] . '</p><hr>';
        }
        echo '</div></div></div></div>';
    }
}
?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="http://localhost/users/gallery/update/">
                        <input type="hidden" name="id" value="<?php echo $info['id'] ?>">
                        <label for="name" class="form-label">Title</label>
                        <input id="name" name="name" type="text" class="form-control"
                               value="<?php echo $info['name'] ?>">
                        <label for="description" class="form-label">Description</label>
                        <textarea rows="10" name="description" id="description" type="text"
                                  class="form-control"><?php echo $info['description'] ?></textarea>
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
