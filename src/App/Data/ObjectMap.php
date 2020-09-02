<?php

namespace App\Data;

class ObjectMap extends Map {
    
    public function exists($name) {
        return isset($this->value->$name);
    }
    
    public function get($name, $default = null) {
        if ($this->exists($name)) {
            return Value::create($this->value->$name);
        }
        return Value::create($default);
    }

}
