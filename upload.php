<?php
$config = require 'config.php';
$dir = $config['uploads_dir'];

if (!file_exists($dir . '/')) {
    mkdir($dir);
}

if (isset($_FILES['avatar'])) {

    $errors = [];

    $file = $_FILES['avatar'];
    $target_file = $dir . '/' . basename($_FILES['avatar']['name']);
    $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $errors['file'] = 'File already exists!';
    }
    if ($file['size'] > $config['max_size']) {
        $errors['size'] = 'File is too large!';
    }
    if (!in_array($fileExt, $config['allowed_types'])) {
        $errors['type'] = 'File type not allowed!';
    }

    if (empty($errors)) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            echo 'File uploaded successfully';
            exit();
        }
        die('Upload failed');
    }

    echo json_encode($errors);
    return;
}