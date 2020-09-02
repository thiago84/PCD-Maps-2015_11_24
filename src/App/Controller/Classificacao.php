<?php

namespace App\Controller;

class Classificacao extends Controller {

    public function delete($id) {
        $this->deleteDenunciaByClassificacao($id);
        parent::delete($id);
    }

    private function deleteDenunciaByClassificacao($id) {
        $denuncias = $this->em->getRepository("App\Entity\Denuncia")->findBy(array("classificacao" => $id));
        foreach($denuncias as $denuncia) {
            $this->em->remove($denuncia);
            $this->em->flush($denuncia);
        }
    }
}
