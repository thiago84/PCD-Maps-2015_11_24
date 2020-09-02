<?php

namespace App\Controller;

class Facebook extends Entrar {

    public function post() {
        $facebookId = $this->context->getRequest()->get("id")->asInt();
        $facebookEmail = $this->context->getRequest()->get("email", $facebookId)->asString();
        $facebookName = $this->context->getRequest()->get("name")->asString();
        
        $usuario = $this->getRepository()->findOneBy(
            array(
                "email" => $facebookEmail,
                "facebook" => $facebookId
            )
        );
        
        if (!$usuario) {
            $usuario = new \App\Entity\Usuario();
            $usuario->setNome($facebookName);
            $usuario->setEmail($facebookEmail);
            $usuario->setFacebook($facebookId);
            $usuario->setSenha($facebookId);
            
            $this->em->persist($usuario);
            $this->em->flush();
        }
        
        $this->setSessionToken($usuario);
        return $this->getSessionToken();
    }

}
