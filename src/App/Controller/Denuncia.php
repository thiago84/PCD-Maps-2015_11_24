<?php

namespace App\Controller;

class Denuncia extends Controller {

    protected function prePersist($entity) {
        $this->removerImagem($entity);
        $this->definirUsuario($entity);
    }

    protected function preUpdate($entity) {
        $this->removerImagem($entity);
    }

    protected function removerImagem($entity) {
        if (!$entity->getImagem() || !$entity->getImagem()->getNome()) {
            $entity->setImagem(null);
        }
    }

    protected function definirUsuario($entity) {
        $usuarioSession = $this->context->getUser();
        if ($usuarioSession) {
            $usuario = $this->em->getRepository("\App\Entity\Usuario")->find($usuarioSession->getId());
            $entity->setUsuario($usuario);
        } else {
            throw new \App\ApplicationException("Usuário deslogado.", 401);
        }
    }

}
