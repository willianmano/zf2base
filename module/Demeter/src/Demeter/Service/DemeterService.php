<?php

namespace Demeter\Service;

use Core\Service\BaseService;

use Admin\Entity\Modulo;
use Admin\Entity\Recurso;
use Admin\Entity\Permissao;
use Admin\Entity\Perfil;

class DemeterService extends BaseService
{
    public function persistModulo($moduloName) {
        
        $moduloName = ucfirst($moduloName);

        $em = $this->getEntityManager();
        
        $modulo = $em->getRepository('Admin\Entity\Modulo')->findBy(array('mod_nome' => $moduloName));
        $modulo = current($modulo);

        if (empty($modulo)) {
            $data['mod_nome'] = $moduloName;
            $data['mod_descricao'] = "Módulo " . $moduloName;
            $data['mod_icone'] = "fa-desktop";
            $data['mod_ativo'] = 1;

            $modulo = new Modulo;
            $modulo->exchangeArray($data);

            $em->persist($modulo);
            $em->flush();
        }

        return $modulo;
    }
    public function persistRecurso($recursoName, $moduloId) {

        $em = $this->getEntityManager();
        
        $recurso = $em->getRepository('Admin\Entity\Recurso')->findBy(array('rcs_nome' => $recursoName, 'rcs_mod_id' => $moduloId));
        
        $recurso = current($recurso);

        if (empty($recurso)) {
            $data['rcs_mod_id'] = $moduloId;
            $data['rcs_ctr_id'] = 1;
            $data['rcs_nome'] = $recursoName;
            $data['rcs_descricao'] = "Recurso " . $recursoName;
            $data['rcs_icone'] = "fa-cog";
            $data['rcs_ativo'] = 1;

            $recurso = new Recurso;
            $recurso->exchangeArray($data);

            $em->persist($recurso);
            $em->flush();
        }

        return $recurso;
    }
    public function persistPermissao($permissaoName, $recursoId) {
        $em = $this->getEntityManager();
        
        $permissao = $em->getRepository('Admin\Entity\Permissao')->findBy(array('prm_nome' => $permissaoName, 'prm_rcs_id' => $recursoId));
        
        $permissao = current($permissao);

        if (empty($permissao)) {
            $data['prm_rcs_id'] = $recursoId;
            $data['prm_nome'] = $permissaoName;
            $data['prm_descricao'] = "Permissao " . $permissaoName;

            $permissao = new Permissao;
            $permissao->exchangeArray($data);

            $em->persist($permissao);
            $em->flush();
        }

        return $permissao;
    }
    public function persistPerfilPermissao($permissaoId, $moduloId) {
        $em = $this->getEntityManager();
        $repository = $this->getDbalConnection();
        
        $sql = "SELECT * FROM seg_perfis WHERE prf_mod_id = ? LIMIT 1";
        $perfil = $repository->executeQuery($sql, array($moduloId))->fetchAll(\PDO::FETCH_CLASS);
        $perfil = current($perfil);

        if (empty($perfil)) {
            $data['prf_mod_id'] = $moduloId;
            $data['prf_nome'] = "Administrador";
            $data['prf_descricao'] = "Perfil de administrador";

            $perfil = new Perfil;
            $perfil->exchangeArray($data);

            $em->persist($perfil);
            $em->flush();
        }

        $sql = "SELECT * FROM seg_perfis_permissoes WHERE prp_prf_id = ? AND prp_prm_id = ?";
        $data = array($perfil->prf_id, $permissaoId);
        $perfilPermissao = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);

        $perfilPermissao = current($perfilPermissao);

        if (empty($perfilPermissao)) {
            $sql = "INSERT INTO seg_perfis_permissoes (`prp_prf_id`, `prp_prm_id`) VALUES (".$perfil->prf_id.", ".$permissaoId.")";
            $repository->executeQuery($sql);
        }

        return true;
    }
}