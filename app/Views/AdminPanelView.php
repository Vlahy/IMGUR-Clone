<?php
include HEADER;
include NAVIGATION;
?>
    <div class="container">
        <div class="row mt-5 justify-content-center align-items-center">
            <div class="col-4">
                <div class="card">
                    <form class="card-body" method="post" action="http://localhost/admin/changeRole">
                        <h5 class="card-header">Change role</h5>
                        <label for="user_id" class="form-label">Insert user id</label>
                        <input class="input-group" type="text" name="user_id">
                        <label for="role" class="form-label">Choose role</label>
                        <select class="form-select" name="role">
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                        <button id="submit" type="submit" value="submit" class="btn btn-outline-primary mt-2">Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
<?php
if (isset($data)) {
    $counter = 0;
    echo '
                <div class="row align-items-center justify-content-center mt-5">
                <div class="col">
                <div class="card">
                <h4 class="card-header">Logger</h4>';
    foreach ($data as $value) {
        echo '
                <div class="card-body"><h5 class="card-title">Moderator ' . $value["username"] . ' ' . $value["comment"] . '</h5>
                <p class="card-text">Date: ' . $value['date'] . '</p>';
        if ($value['image_id'] != null) {
            echo '<a class="btn btn-outline-primary" href="http://localhost/users/image/' . $value['image_id'] . '">Image link</a></div>';
        } elseif ($value['gallery_id'] != null) {
            echo '<a class="btn btn-outline-primary" href="http://localhost/users/gallery/' . $value['gallery_id'] . '">Gallery link</a></div>';
        }
        echo '<hr>';
        $counter++;
    }
    echo '</div></div></div>';

    include PAGE_NAVIGATION;
}
echo '</div>';
include FOOTER;
