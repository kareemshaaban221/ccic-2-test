<?php

#[\AllowDynamicProperties]
class Auth {

    public function __construct(...$attributes) {
        foreach ($attributes as $field => $value) {
            $this->$field = $value;
        }
    }

    public function __get($var_name) {
        return $this->$var_name;
    }

    public function __set($var_name, $val) {
        $this->$var_name = $val;
    }

}
