<?php

namespace Slim\Extras\View;

class Json extends \Slim\View {

    public function render($status = 200, $data = null) {
        $response = $this->all();
        
		if (isset($response["data"])) {
            $app = \Slim\Slim::getInstance();
            $app->response()->status($status);
            $app->response()->header("Content-Type", "application/json");
            $app->response()->body(json_encode($response["data"]));
            $app->stop();
        }
    }

}
