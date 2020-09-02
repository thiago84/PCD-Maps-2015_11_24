<?php

namespace App\Data;

class Value {
    
    protected $value;
    
    private function __construct($value) {
        $this->value = $value;
    }

    public static function create($value) {
        switch(gettype($value)) {
            case "array": return new ArrayMap($value);
            case "object": return new ObjectMap($value);
            default: return new Value($value);
        }
    }

    public function asValue() {
        return $this->value;
    }

    public function asString() {
        return strval($this->value);
    }
    
    public function asInt() {
        return intval($this->value);
    }

    public function asMap() {
        return self::create($this->value);
    }

}
