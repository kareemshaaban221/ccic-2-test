<?php

require_once __DIR__ . '/../helpers/functions.php';

class FileManager {

    private string $upload_path;

    function __construct() {
        $this->upload_path = config('app', 'upload_path');
    }

    function store($file): bool|string {
        $from = $file['tmp_name'];
        $new_file_name = time() . '.' . $this->getFileExtension($file);
        $target = $this->upload_path . '/' . $new_file_name;
        return move_uploaded_file($from, $target) ? $new_file_name : false;
    }

    function delete($filename): bool {
        $target = $this->upload_path . '/' . $filename;
        if (file_exists($target)) {
            unlink($target);
            return true;
        } else {
            return false;
        }
    }

    private function getFileExtension($file): string {
        return explode('.', $file['name'])[1];
    }

}
