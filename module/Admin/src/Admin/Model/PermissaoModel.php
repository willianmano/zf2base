<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class PermissaoModel extends BaseModel
{
    public function __construct(){
        $this->setEntity('Admin\Entity\Permissao');
    }
    public function getPermissaoByIdJoinRecursos($id)
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT r.rcs_mod_id as prm_modulo, p.* FROM seg_permissoes p
                LEFT JOIN seg_recursos r on r.rcs_id = p.prm_rcs_id
                WHERE prm_id = ?";
        $data = array($id);

        $permissao = $repository->executeQuery($sql, $data)->fetchAll();

        if($permissao)
            $permissao = $permissao[0];

        return $permissao;
    }
}