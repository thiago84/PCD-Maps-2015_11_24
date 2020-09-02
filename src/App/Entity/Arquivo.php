<?php

namespace App\Entity;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Arquivo extends Entity {
    
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
    protected $url;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @var string
     */
    protected $data;

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function salvarArquivo() {
		if (isset($this->data)) {
			$filename = $this->getNomeArquivo();
			$fullpath = UPLOAD_DIR . "/" . $filename;
            
			$imagemEncode = "base64,";
			$imagemData = substr(strstr($this->data, $imagemEncode), strlen($imagemEncode));
			
			file_put_contents($fullpath, base64_decode($imagemData));
			
            $this->url  = "/envios/" . $filename;
            $this->data = null;
		}
    }

    /**
     * @PostRemove
     */
    public function removerArquivo() {
        @unlink(UPLOAD_DIR . "/" . $this->getNomeArquivo());
    }

    private function getNomeArquivo() {
        return basename($this->url) . "." . pathinfo($this->nome, PATHINFO_EXTENSION);
    }

}
