<?php

class Server {

    public array $server;

    public function __construct() {
        $this->server = $_SERVER;
    }

    public function isPostRequest(): bool {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function isGetRequest(): bool {
        return $this->server['REQUEST_METHOD'] === 'GET';
    }


}
