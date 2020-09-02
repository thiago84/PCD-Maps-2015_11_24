<?php

namespace App\Controller;

class Usuario extends Controller {

    public function delete($id) {
        $this->deleteDenunciaByUsuario($id);
        parent::delete($id);
    }

    private function deleteDenunciaByUsuario($id) {
        $denuncias = $this->em->getRepository("App\Entity\Denuncia")->findBy(array("usuario" => $id));
        foreach($denuncias as $denuncia) {
            $this->em->remove($denuncia);
            $this->em->flush($denuncia);
        }
    }
}
