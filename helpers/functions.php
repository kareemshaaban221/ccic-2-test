<?php

require_once __DIR__ . "/../models/Auth.php";
require_once __DIR__ . "/../core/Server.php";
require_once __DIR__ . "/../core/Request.php";
require_once __DIR__ . "/../core/FileManager.php";

function dd(...$args) {
    echo "<pre>";
    foreach ($args as $arg) {
        echo var_dump($arg);
    }
    echo "</pre>";
    die;
}

function auth(): ?Auth {
    $user = null;
    $is_authenticated = false;

    if (!empty($_SESSION['user'])) {
        $user = new Auth(...unserialize($_SESSION['user']));
        $is_authenticated = true;
    }

    if (! $is_authenticated) {
        $_SESSION['errors'] = [
            'Unauthenticated!'
        ];
        header(header: 'Location: login.php');
        exit;
    }

    $is_authorized = true;

    return $user;
}

function guest(): ?bool {
    $is_authenticated = !empty($_SESSION['user']);

    if ($is_authenticated) {
        $_SESSION['errors'] = [
            'Logout, first!'
        ];
        header('Location: index.php');
        exit;
    }

    return true;
}

function server(): ?Server {
    return new Server();
}

function request(): ?Request {
    return new Request();
}

function fileManager(): ?FileManager {
    return new FileManager();
}

function config($file, $key) {
    $configs = require __DIR__ . "/../config/" . $file . ".php";
    return $configs[$key];
}
