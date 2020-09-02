<?php

namespace App;

class Mapper {

    private $em;

    public function __construct($em) {
        $this->em = $em;
    }

    public function requestToEntity($entityName, $request) {
        $entityNameWithNamespace = "\App\Entity\\" . $entityName;
        
        if (isset($request->id) && is_numeric($request->id)) {
            $entity = $this->em->getRepository($entityNameWithNamespace)->find($request->id);
        } else {
            $entity = new $entityNameWithNamespace();
        }
        
        $reflectionClass = new \ReflectionClass($entityNameWithNamespace);
        
        foreach($request as $name => $value) {
            if ($reflectionClass->hasProperty($name) && $value !== null) {
                $property = $reflectionClass->getProperty($name);
                
                $propertyType = $this->getPropertyType($property);
                
                if (is_object($value)) {
                    $value = $this->requestToEntity($propertyType, $value);
                }
                
                if ($propertyType === "\DateTime") {
                    $value = \DateTime::createFromFormat("d/m/Y H:i:s", $value);
                }
                
                $property->setAccessible(true);
                $property->setValue($entity, $value);
            }
        }
        
        return $entity;
    }

    private function getPropertyType($property, $matches = array()) {
        if (preg_match('/@var\s+([^\s]+)/', $property->getDocComment(), $matches)) {
            return $matches[1];
        }
        return "string";
    }

}
