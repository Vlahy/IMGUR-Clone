<?php

include HEADER;
include NAVIGATION;


if (isset($data) && $data != false) {
    $items = 0;
    echo '<div class="container">';
    echo '<div class="row row-cols-4">';
    foreach ($data as $value) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $value->user_id) {
            if ($value->nsfw == 0 || $value->hidden == 0) {
                echo '<div class="col"><a href="http://localhost/users/image/' . $value->id . '"><img class="shadow-1-strong rounded m-4"
             src="' . $value->file_name . '?random=' . $value->id . '"
              alt="' . $value->slug . '"></a></div>';
            }
        } else {
            echo '<div class="col"><a href="http://localhost/users/image/' . $value->id . '"><img class="shadow-1-strong rounded m-4"
             src="' . $value->file_name . '?random=' . $value->id . '"
              alt="' . $value->slug . '"></a></div>';
        }
        $items++;
    }
    echo '</div>';
    echo '</div>';

    $page = $_GET['page'] ?? 1;
    echo '<div class="col d-flex justify-content-center">';
    if ($page > 1) {
        echo '<a class="btn btn-success m-4" href="?page=' . ($page - 1) . '">Previous Page</a>';
    }elseif ($items == 10){
    echo '<a class="btn btn-success m-4" role="button" href="?page=' . ($page + 1) . '">Next Page</a>';
    echo '</div>';
    }
}

include FOOTER;
