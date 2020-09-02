<?php

namespace App\Controller;

class Entrar extends Controller {

    protected function getRepository() {
        return $this->em->getRepository("App\Entity\Usuario");
    }

    public function find() {
        return $this->getSessionToken();
    }

    public function post() {
        $usuario = $this->getRepository()->findOneBy(
            array(
                "email" => $this->context->getRequest()->get("email")->asString(),
                "senha" => $this->context->getRequest()->get("senha")->asString()
            )
        );
        
        if ($usuario) {
            $this->setSessionToken($usuario);
            return $this->getSessionToken();
        } else {
            throw new \App\ApplicationException("Email ou senha incorreto(s).", 403);
        }
    }

    protected function getUserToken($usuario) {
        return base64_encode($usuario->getEmail() . ":" . $usuario->getSenha());
    }

    protected function getUserName($usuario) {
        if ($usuario) {
            return strtok($usuario->getNome(), " ");
        } else {
            return "Anônimo";
        }
    }

    protected function getModules($usuario) {
        if ($usuario->getId() === 1) {
            return array(
                array("href" => "#/painel/denuncias", "title" => "Denúncias"),
                array("href" => "#/painel/classificacoes", "title" => "Classificações"),
                array("href" => "#/painel/usuarios", "title" => "Usuários"),
                array("href" => "#/painel/contatos", "title" => "Contatos")
            );
        } else {
            return array(
                array("href" => "#/painel/denuncias", "title" => "Denúncias")
            );
        }
    }

    protected function setSessionToken($usuario) {
        $token = $this->getUserToken($usuario);
        
        $this->context->getApp()->setCookie("token", $token);
        $this->context->setUser($usuario);
    }

    protected function getSessionToken() {
        $usuario = $this->context->getUser();
        
        if (!$usuario) {
            return null;
        }
        
        return array(
            "token" => $this->getUserToken($usuario),
            "username" => $this->getUserName($usuario),
            "modules" => $this->getModules($usuario)
        );
    }

	public function delete($id) {
		$this->context->getApp()->setCookie("token", null);
	}

}
