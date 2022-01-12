<?php

$page = $_GET['page'] ?? 1;
echo '<div class="row align-items-center justify-content-around">';
if ($page <= 1) {
    $disabled = "disabled";
} else {
    $disabled = '';
}
echo '<div class="col"><a class="btn btn-outline-primary m-4 ' . $disabled . '" href="?page=' . ($page - 1) . '">Previous Page</a></div>';
/** @var int $counter */
if ($counter < 10) {
    $disable = "disabled";
} else {
    $disable = '';
}
echo '<div class="col"><a class="btn btn-outline-primary m-4 float-end' . $disable . '" role="button" href="?page=' . ($page + 1) . '">Next Page</a></div>';

echo '</div>';
