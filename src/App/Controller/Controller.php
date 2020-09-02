<?php

namespace App\Controller;

abstract class Controller implements \App\Api\Resource {

    /**
     *
     * @var \App\Context
     */
    protected $context;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * 
     * @param \App\Context $context
     */
    public function __construct($context) {
        $this->context = $context;
        $this->em = $context->getEm();
    }

    public function find() {
        if ($this->context->getRequest()->count()) {
            return $this->getRepository()->findBy($this->context->getRequest()->asValue());
        }
        return $this->getRepository()->findAll();
    }

    public function get($id) {
        return $this->getRepository()->find($id);
    }

    public function post() {
        $entity = $this->getEntityFromRequest();
        
        $this->prePersist($entity);
        
        $this->em->persist($entity);
        $this->em->flush($entity);
        
        return $entity;
    }

    public function put($id) {
        $entity = $this->getEntityFromRequest();
        
        $this->preUpdate($entity);
        
        $this->em->persist($entity);
        $this->em->flush($entity);
        
        return $entity;
    }

    public function delete($id) {
        $entity = $this->getRepository()->find($id);
        $this->em->remove($entity);
        $this->em->flush($entity);
    }

    protected function getEntityFromRequest() {
        $mapper = new \App\Mapper($this->em);
        return $mapper->requestToEntity($this->getClassname(), $this->context->getRequest()->asValue());
    }
    
    protected function getClassname() {
        $reflectionClass = new \ReflectionClass($this);
        return $reflectionClass->getShortName();
    }

    protected function getRepository() {
        if (!$this->repository) {
            $this->repository = $this->em->getRepository(str_replace("Controller", "Entity", get_class($this)));
        }
        return $this->repository;
    }

    protected function prePersist($entity) {}

    protected function preUpdate($entity) {}

}
