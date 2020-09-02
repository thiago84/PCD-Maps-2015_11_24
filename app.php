<?php

ini_set("display_errors" , 1);
ini_set("error_reporting", E_ALL);

session_cache_limiter(false);
session_start();

define("ROOT_DIR"  , str_replace("\\", "/", __DIR__));
define("UPLOAD_DIR", ROOT_DIR . "/envios");

require ROOT_DIR . '/vendor/autoload.php';

spl_autoload_register(function($classname) {
	$filename = str_replace("\\", "/", "src/" . $classname . ".php");
	if (file_exists($filename)) {
		include_once($filename);
		return true;
	}
	return false;
});

$app = new \Slim\Slim(array('debug' => false));
$app->view(new \Slim\Extras\View\Json());
$app->add(new \Slim\Extras\Middleware\Error());
// $app->add(new \Slim\Extras\Middleware\Authentication());

$app->container->singleton('handler', function ($container) use ($app) {
    return new App\Handler($app);
});

$app->get('/', function () use($app) {
    $app->contentType("text/html");
    $app->response->body(file_get_contents(ROOT_DIR . "/index.php"));
});

$app->get('/api/:controller', function ($controller) use($app) {
    $app->render(200, array(
        "data" => $app->handler->execute($controller, "find", array())
    ));
});

$app->get('/api/:controller/:id', function ($controller, $id = null) use($app) {
    $app->render(200, array(
        "data" => $app->handler->execute($controller, "get", array("id" => $id))
    ));
});

$app->post('/api/:controller', function ($controller) use ($app) {
    $app->render(201, array(
        "data" => $app->handler->execute($controller, "post", array())
    ));
});

$app->put('/api/:controller/:id', function ($controller, $id) use ($app) {
    $app->render(200, array(
        "data" => $app->handler->execute($controller, "put", array("id" => $id))
    ));
});

$app->delete('/api/:controller/:id', function ($controller, $id) use ($app) {
    $app->render(200, array(
        "data" => $app->handler->execute($controller, "delete", array("id" => $id))
    ));
});

$app->run();
