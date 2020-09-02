<?php

namespace App\Controller;

class Estatisticas extends Controller {

    public function find() {
        $usuarios = $this->em->createQueryBuilder()
                ->select("COUNT(u.id) as total")
                ->from("App\Entity\Usuario", "u")
                ->getQuery()
                ->getSingleScalarResult();
        
        $denuncias = $this->em->createQueryBuilder()
                ->select("COUNT(d.id) as total")
                ->from("App\Entity\Denuncia", "d")
                ->getQuery()
                ->getSingleScalarResult();
        
        $denunciasPorClassificacao = $this->em->createQueryBuilder()
                ->select("c.nome, COUNT(c.id) as total")
                ->from("App\Entity\Classificacao", "c")
                ->join("App\Entity\Denuncia", "d", "WITH", "d.classificacao = c.id")
                ->groupBy("c.id")
                ->getQuery()
                ->getArrayResult();
        
        $denunciasPorBairro = $this->em->createQueryBuilder()
                ->select("d.bairro as nome, COUNT(d.bairro) as total")
                ->from("App\Entity\Denuncia", "d")
                ->where("d.bairro is not null")
                ->groupBy("d.bairro")
                ->getQuery()
                ->getArrayResult();
        
        return array(array(
            "usuarios" => $usuarios,
            "denuncias" => $denuncias,
            "classificacao" => $denunciasPorClassificacao,
            "localidade" => $denunciasPorBairro
        ));
    }

}
