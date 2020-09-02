<?php

namespace App;

class Session {

    public static function exists($name) {
        return isset($_SESSION[$name]);
    }

    public static function set($name, $value) {
        $_SESSION[$name] = serialize($value);
    }

    public static function get($name) {
        if (Session::exists($name) && is_string($_SESSION[$name])) {
            return unserialize($_SESSION[$name]);
        }
        return null;
    }

}
