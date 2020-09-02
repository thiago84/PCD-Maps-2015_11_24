<?php

namespace Slim\Extras\Middleware;

class Error extends \Slim\Middleware {

    public function call() {
        $this->test($this->app);
        
        $this->error($this->app);
        $this->notFound($this->app);
        
        return $this->next->call();
    }

    private function test($app) {
        $app->get('/test', function() use ($app) {
            $app->render(200, array(
                "data" => array(
                    "method"    => $app->request()->getMethod(),
                    "headers"   => $app->request()->headers(),
                    "params"    => $app->request()->params()
                )
            ));
        });
    }

    private function error($app) {
        $app->error(function (\Exception $e) use ($app) {
            if (is_a($e, "\App\ApplicationException")) {
                $app->render($e->getCode(), array(
                    "data" => array(
                        "error" => array(
                            "code"    => $e->getCode(),
                            "message" => $e->getMessage(),
                        )
                    )
                ));
            } else {
                $app->render(500, array(
                    "data" => array(
                        "error" => array(
                            "code"    => 500,
                            "message" => "Erro desconhecido.",
                            "error"   => $e->getMessage(),
                            "file"    => $e->getFile(),
                            "line"    => $e->getLine()
                        )
                    )
                ));
            }
        });
    }

    private function notFound($app) {
        $app->notFound(function() use ($app) {
            $app->render(404, array(
                "data" => array(
                    "error" => array(
                        "code"    => 404,
                        "message" => "Recurso não encontrado."
                    )
                )
            ));
        });
    }
}
