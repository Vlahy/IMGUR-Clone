<?php

include HEADER;
include NAVIGATION;
if (isset($data) && $data != false) {
    echo '<div class="container align-items-center justify-content-center">';
    echo '<div class="row row-cols-1">';
    if (isset($_SESSION['user_id'])) {
        echo '<div class="row bg-light p-4 m-4 border border-4 rounded">';
        if ($_SESSION['role'] == 'moderator' || $_SESSION['role'] == 'admin') {
            echo '<div class="col d-flex align-items-center justify-content-center"><form action="http://localhost/users/image/nsfw/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-danger btn-lg p-2 m-2 float-end">NSFW</button></form></div>';
            echo '<div class="col d-flex align-items-center justify-content-center"><form action="http://localhost/users/image/hidden/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-danger btn-lg p-2 m-2 float-end">Hidden</button></form></div>';
        }
        if ($_SESSION['user_id'] == $data['user_id']) {
            echo '<div class="col d-flex align-items-center justify-content-center"><form action="http://localhost/users/image/delete/' . $data['id'] . '" method="post">
                <button type="submit" class="btn btn-danger btn-lg p-2 m-2 float-end">Delete</button></form></div>';
        }
        echo '</div>';
    }

    echo '<div class="col"><img class="shadow-1-strong rounded m-4 d-flex align-items-center"
             src="' . $data['file_name'] . '?random=' . $data['id'] . '"
              alt="' . $data['slug'] . '"></div>';

    echo '</div></div>';
}

include FOOTER;
