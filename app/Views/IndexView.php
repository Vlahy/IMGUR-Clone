<?php

include HEADER;
include NAVIGATION;

if (isset($_SESSION['user_id'])) {
    header('Location: /users/profile/' . $_SESSION['user_id']);
}

if (isset($data)) {

    $counter = 0;
    echo '<div class="container"><div class="row row-cols-3 g-4">';
    foreach ($data as $value) {

        echo '<div class="col-sm-4 align-items-center mt-5"><div class="card" style="width: 340px"><a href="http://localhost/users/image/' . $value['id'] .
            '"><img class="card-image-top mx-2 my-2"
             src="' . $value['file_name'] . '?random=' . $value['id'] . '"
              alt="' . $value['slug'] . '"></a>
              
              </div>
              </div>';

        $counter++;
    }
    echo '</div>';

    include PAGE_NAVIGATION;

    echo '</div>';

}