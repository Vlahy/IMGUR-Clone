<?php
include HEADER;
include NAVIGATION;

if (isset($data) && $data != null) {
    echo '<div class="container">';
    $counter = 0;
    foreach ($data as $value) {
        echo '<div class="row row-cols-5 align-items-center bg-light p-4 m-4 border border-4 rounded">';

        echo '<div class="col d-flex justify-content-center border-bottom">Name</div>
                <div class="col d-flex justify-content-center border-bottom">Description</div>
                <div class="col d-flex justify-content-center border-bottom">Slug</div>
                <div class="col d-flex justify-content-center border-bottom">&nbsp</div>
                <div class="col d-flex justify-content-center border-bottom">&nbsp</div>';

        echo '<div class="col d-flex justify-content-center p-2">' . $value->name . '</div>';
        echo '<div class="col d-flex justify-content-center p-2">' . $value->description . '</div>';
        echo '<div class="col d-flex justify-content-center p-2">' . $value->slug . '</div>';
        echo '<div class="col d-flex justify-content-center p-2"><a class="btn btn-success" href="http://localhost/users/gallery/' . $value->id . '">Open Gallery</a></div>';

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $value->user_id) {
            echo '<div class="col d-flex justify-content-center"><form action="http://localhost/users/gallery/delete/' . $value->id . '" method="post">
                    <button type="submit" class="btn btn-danger p-2">Delete</button></form></div>';
        }
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'moderator' || $_SESSION['role'] == 'admin'){
            echo '<div class="col d-flex align-items-center justify-content-center"><form action="http://localhost/users/gallery/nsfw/' . $value->id . '" method="post">
                <button type="submit" class="btn btn-danger">NSFW</button></form></div>';
            echo '<div class="col d-flex align-items-center justify-content-center"><form action="http://localhost/users/gallery/hidden/' . $value->id . '" method="post">
                <button type="submit" class="btn btn-danger">Hidden</button></form></div>';
        }
        echo '</div>';
        $counter++;
    }

    $page = $_GET['page'] ?? 1;
    echo '<div class="col d-flex justify-content-center">';
    if ($page > 1) {
        echo '<a class="btn btn-success m-4" href="?page=' . ($page - 1) . '">Previous Page</a>';
    }
    if ($counter == 10) {
        echo 'Page' .$page . '<a class="btn btn-success m-4" role="button" href="?page=' . ($page + 1) . '">Next Page</a>';
        echo '</div></div>';
    }
}

include FOOTER;
