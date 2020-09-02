<?php

namespace App;

class Context {

    /**
     *
     * @var \Slim\Slim
     */
    private $app;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     *
     * @var Entity\Usuario
     */
    private $user;

    /**
     *
     * @var Data\Map
     */
    private $request;

    /**
     *
     * @var Data\Map
     */
    private $params;

    public function getApp() {
        return $this->app;
    }

    public function getEm() {
        return $this->em;
    }

    public function setApp(\Slim\Slim $app) {
        $this->app = $app;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getRequest() {
        return $this->request;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }

}
