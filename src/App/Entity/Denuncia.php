<?php

namespace App\Entity;

/**
 * @Entity
 */
class Denuncia extends Entity {

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
    protected $titulo;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $localizacao;

    /**
     * @Column(type="string",nullable=true)
     * @var string
     */
    protected $bairro;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $latitude;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $longitude;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $descricao;

    /**
     * @ManyToOne(targetEntity="Classificacao")
     * @JoinColumn(name="classificacao_id", referencedColumnName="id")
     * @var Classificacao
     */
    protected $classificacao;

    /**
     * @ManyToOne(targetEntity="Usuario")
     * @JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuario
     */
    protected $usuario;

    /**
     * @ManyToOne(targetEntity="Arquivo", cascade={"all"})
     * @JoinColumn(name="arquivo_id", referencedColumnName="id")
     * @var Arquivo
     */
    protected $imagem;
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getClassificacao() {
        return $this->classificacao;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setClassificacao(Classificacao $classificacao) {
        $this->classificacao = $classificacao;
    }

    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    /**
     * 
     * @param \App\Entity\Arquivo $imagem
     */
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

}
