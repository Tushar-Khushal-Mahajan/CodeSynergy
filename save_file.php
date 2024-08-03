<?php
if (isset($_POST['content']) && isset($_POST['filename'])) {
    $filename = 'files/' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $_POST['filename']) . '.html';
    $content = $_POST['content'];

    if (file_put_contents($filename, $content)) {
        echo 'File saved successfully';
    } else {
        echo 'Error saving file';
    }
}
?>
