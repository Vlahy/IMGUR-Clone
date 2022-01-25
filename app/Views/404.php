<?php
include HEADER;
include NAVIGATION;
?>

    <div class="text-center py-5">
        <h1 class="display-1">404</h1>
        <h2>The page you requested was not found.</h2>
        <button class="btn btn-outline-success" type="button" value="Go back!" onclick="history.back()">Go to previous page</button>
    </div>

<?php

header('HTTP/1.1 404 Not Found');

include FOOTER;