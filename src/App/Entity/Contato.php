<?php

namespace App\Entity;

/**
 * @Entity
 */
class Contato extends Entity {

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
     * @Column(type="string")
     * @var string
     */
    protected $telefone;

    /**
     * @Column(type="string",nullable=true)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string",nullable=true)
     * @var string
     */
    protected $site;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSite() {
        return $this->site;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSite($site) {
        $this->site = $site;
    }

}
