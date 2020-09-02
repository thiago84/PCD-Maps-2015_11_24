<?php

namespace App\Controller;

class MinhaDenuncia extends Denuncia {
    
    protected function getClassname() {
        return "Denuncia";
    }
    
    protected function getRepository() {
        return $this->em->getRepository("App\Entity\Denuncia");
    }

    public function find() {
        return $this->getRepository()->findBy($this->getUserCriteria());
    }

    public function delete($id) {
        $denuncia = $this->getRepository()->findOneBy($this->getUserCriteria(array("id" => $id)));
        
        if ($denuncia) {
            $this->em->remove($denuncia);
            $this->em->flush($denuncia);
        } else {
            throw new \App\ApplicationException("Registro não encontrado.", 404);
        }
    }

    private function getUserCriteria($criteria = array()) {
        $usuario = $this->context->getUser();
        
        if ($usuario->getId() !== 1) {
            $criteria["usuario"] = $usuario;
        }
        
        return $criteria;
    }

    private function checkFiles($denuncias) {
        $arquivosRelacionados = array();
        
        foreach($denuncias as $denuncia) {
            if (isset($denuncia["imagem"]["url"])) {
                $arquivosRelacionados[] = strtolower($denuncia["imagem"]["url"]);
            }
        }
        
        $arquivosFisicos = glob(UPLOAD_DIR . "/*");
        
        $arquivosNaoRelacionados = array();
        foreach ($arquivosFisicos as $filepath) {
            $filename = strtolower("/envios/" . basename($filepath));
            
            if (!in_array($filename, $arquivosRelacionados)) {
                $arquivosNaoRelacionados[] = $filename;
            }
        }
        
        $denunciasSemFotos = $this->getRepository()->findBy(array("imagem" => null));
        
        foreach($denunciasSemFotos as $denuncia) {
            $nome = array_shift($arquivosNaoRelacionados);
            
            if (!$denuncia->getImagem()) {
                $denuncia->setImagem(new \App\Entity\Arquivo());
            }
            
            $denuncia->getImagem()->setNome(basename($nome));
            $denuncia->getImagem()->setUrl($nome);
            
            $this->em->persist($denuncia);
            $this->em->flush($denuncia);
        }
    }

}
