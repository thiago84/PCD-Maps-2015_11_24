<?php

namespace App\Api;

interface Resource {

    public function find();
    public function get($id);
    public function post();
    public function put($id);
    public function delete($id);

}
