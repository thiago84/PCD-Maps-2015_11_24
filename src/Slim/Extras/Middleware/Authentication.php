<?php

namespace Slim\Extras\Middleware;

class Authentication extends \Slim\Middleware {

    public function call() {
        $this->app->hook('slim.before.dispatch', array($this, 'onBeforeDispatch'));
        $this->next->call();
    }

    public function onBeforeDispatch() {
        $route = $this->app->router()->getCurrentRoute();
        
        if (count($route->getParams())) {
            $controller = $route->getParam("controller");
            $method = $this->app->request()->getMethod();
            
            $userControllers = \App\Controller\Entrar::getUsuarioPermissoes();
            
            if (array_key_exists($controller, $userControllers)) {
                $userMethods = $userControllers[$controller];
                if (in_array($method, $userMethods)) {
                    return true;
                }
            }
            
            throw new \App\ApplicationException("Permissão negada.", 401);
        }
    }
}
