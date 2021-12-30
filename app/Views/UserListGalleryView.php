<?php
include HEADER;
include NAVIGATION;

if (isset($data) && $data != null) {
    echo '<div class="container">';
    echo '<h1 class="mt-3 lead display-4">Gallery <small class="text-muted">List</small></h1>';
    echo '<div class="row">';
    $counter = 0;
    foreach ($data as $value) {
        echo '<div class="col-sm-6 gy-4"><div class="card"><div class="card-body">';

        echo '<h5 class="card-title">' . $value->name . '</h5>';
        echo '<p class="card-text">' . $value->description . '</p>';
        echo '<a class="btn btn-primary" href="http://localhost/users/gallery/' . $value->id . '">Open Gallery</a>';

        echo '</div></div></div>';

        $counter++;
    }
    echo '</div>';

    $page = $_GET['page'] ?? 1;
    echo '<div class="row align-items-center justify-content-around">';
    if ($page <= 1) {
        $disabled = "disabled";
    }else {
        $disabled = '';
    }
    echo '<div class="col"><a class="btn btn-outline-primary m-4 ' . $disabled . '" href="?page=' . ($page - 1) . '">Previous Page</a></div>';
    if ($counter == 10) {
        echo '<div class="col d-flex justify-content-center align-items-center h3">' . $page . '</div><div class="col"><a class="btn btn-outline-primary m-4 float-end" role="button" href="?page=' . ($page + 1) . '">Next Page</a></div>';
    }
    echo '</div></div>';
}

include FOOTER;
