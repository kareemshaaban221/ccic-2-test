<?php

class Request {

    public array $request = [];

    public function __construct() {
        $this->request = $_REQUEST;
    }

    public function has($key): bool {
        return ! empty($this->request[$key]);
    }

    public function get($key) {
        return $this->has($key) ? $this->request[$key] : null;
    }

    public function equal($key, $value) {
        return $this->get($key) === $value;
    }

    public function files(): array {
        return $_FILES;
    }

    public function hasFile($key): bool {
        return ! empty($this->files()[$key]);
    }

    public function file($key): mixed {
        return $this->hasFile($key) ? $this->files()[$key] : null;
    }

    
}
