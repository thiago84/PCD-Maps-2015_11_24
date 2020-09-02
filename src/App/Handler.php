<?php

namespace App;

class Handler {

    /**
     *
     * @var Context
     */
    private $context;

    /**
     * 
     * @param \Slim\Slim $slim
     */
    public function __construct($slim) {
        $this->context = new Context();
        $this->context->setApp($slim);
        $this->setupRequest();
        $this->setupEntityManager();
        $this->setupUser();
    }

    public function execute($controller, $action, $parameters) {
        $this->setupAuthorization($controller);
        $this->context->setParams(Data\Value::create($parameters));
        
        $classname = "\App\Controller\\" . $controller;
        $classe = new $classname($this->context);
        return call_user_func_array(array($classe, $action), $parameters);
    }

    private function setupRequest() {
        $request = json_decode($this->context->getApp()->request()->getBody());
        
        if (!$request) {
            $request = $this->context->getApp()->request()->params();
        }
        
        $this->context->setRequest(Data\Value::create($request));
    }

    private function setupEntityManager() {
        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => ROOT_DIR . '/db.sqlite');

        /*
          $conn = array(
          'driver' => 'pdo_mysql',
          'host' => 'localhost',
          'user' => 'root',
          'password' => '',
          'dbname' => 'maps');
         */

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src/App/Entity"), $isDevMode = true);
        $entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

        $tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = array(
            $entityManager->getClassMetadata('App\Entity\Usuario'),
            $entityManager->getClassMetadata('App\Entity\Arquivo'),
            $entityManager->getClassMetadata('App\Entity\Classificacao'),
            $entityManager->getClassMetadata('App\Entity\Denuncia'),
            $entityManager->getClassMetadata('App\Entity\Contato')
        );
        
        /*
          echo "<pre>";
          print_r($tool->getCreateSchemaSql($classes));
          print_r($tool->getUpdateSchemaSql($classes));
          exit;
        */
        
        // $tool->dropSchema($classes);
        // $tool->createSchema($classes);
        // $tool->updateSchema($classes);
        
        $this->context->setEm($entityManager);
    }

    private function setupUser() {
        $repository = $this->context->getEm()->getRepository("App\Entity\Usuario");
        $usuario = $repository->findOneBy(array(
            "email" => $this->context->getApp()->request->headers("Php-Auth-User"),
            "senha" => $this->context->getApp()->request->headers("Php-Auth-Pw")
        ));
        
        $this->context->setUser($usuario);
    }

    private function setupAuthorization($controller) {
        $usuario = $this->getUser();
        $method = $this->context->getApp()->request()->getMethod();
        
        if ($usuario->role === "admin") {
            return true;
        }
        
        if (array_key_exists($controller, $usuario->modules)) {
            $userMethods = $usuario->modules[$controller];
            if (in_array($method, $userMethods)) {
                return true;
            }
        }
        
        throw new \App\ApplicationException("Permissão negada.", 401);
    }
    
    private function getUser() {
        $usuario = $this->context->getUser();
        
        if ($usuario) {
            if ($usuario->getId() === 1) {
                $usuario->role = "admin";
                $usuario->modules = array();
            } else {
                $usuario->role = "user";
                $usuario->modules = array(
                    "Classificacao" => array("GET"),
                    "Denuncia"      => array("GET"),
                    "Entrar"        => array("GET", "POST", "DELETE"),
                    "Usuario"       => array("GET"),
                    "MinhaDenuncia" => array("GET", "POST", "PUT", "DELETE"),
                    "Estatisticas"  => array("GET"),
                    "Contato"       => array("GET")
                );
            }
        } else {
            $usuario = new \App\Entity\Usuario();
            $usuario->role = "public";
            $usuario->modules = array(
                "Denuncia"     => array("GET"),
                "Entrar"       => array("GET", "POST"),
                "Usuario"      => array("POST"),
                "Facebook"     => array("GET", "POST"),
                "Estatisticas" => array("GET"),
                "Contato"      => array("GET")
            );
        }
        
        return $usuario;
    }
}
