<?php

namespace App\Entity;

/**
 * @Entity
 */
class Usuario extends Entity {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $nome;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $senha;

    /**
     * @Column(type="integer",nullable=true)
     * @var int
     */
    protected $pontuacao;
    
    /**
     * @Column(type="string",nullable=true)
     * @var string
     */
    protected $facebook;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getPontuacao() {
        return $this->pontuacao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setPontuacao($pontuacao) {
        $this->pontuacao = $pontuacao;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function jsonSerialize() {
        $data = parent::jsonSerialize();
        unset($data["senha"]);
        return $data;
    }

}
