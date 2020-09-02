<?php

namespace App\Data;

abstract class Map extends Value {

    public function count() {
        return count($this->value);
    }

    abstract public function exists($name);
    
    abstract public function get($name, $default = null);

}
