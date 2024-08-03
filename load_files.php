<?php
$files = glob('files/*.html');
foreach ($files as $file) {
    $filename = basename($file, '.html');
    echo "<li class='list-group-item d-flex justify-content-between align-items-center'><a href='#' onclick='loadFile(\"$filename\")'>$filename</a> <a href='files/$filename.html' download class='btn btn-sm btn-secondary'><i class='fas fa-download'></i></a></li>";
}
?>
