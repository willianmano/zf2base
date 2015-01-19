<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;

class PerfisPermissoesController extends BaseController
{
    public function indexAction()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT p.*, m.mod_nome FROM seg_perfis p LEFT JOIN seg_modulos m on m.mod_id = p.prf_mod_id";
        $perfis = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);

        return new ViewModel(
            array(
                'perfis' => $perfis
            )
        );
    }
    public function atribuirpermissoesperfilAction()
    {
        $idPerfil = (int) $this->params()->fromRoute('id');

        $repository = $this->getDbalConnection();
        $sql = "SELECT p.prf_id, p.prf_nome, m.mod_id, m.mod_nome FROM seg_perfis p
                LEFT JOIN seg_modulos m ON m.mod_id = p.prf_mod_id
                WHERE prf_id = ?";
        $data = array($idPerfil);
        $perfil = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
        $perfil = current($perfil);

        $sql = "SELECT rcs_id, rcs_nome, prm_id, prm_nome, IF(bol = 1, 1, 0) as habilitado 
                FROM (
                    SELECT rcs_id, rcs_nome, prm_id, prm_nome  FROM seg_permissoes p
                    LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                    WHERE r.rcs_mod_id = ?
                ) as todas
                LEFT JOIN (
                        SELECT prm_id as temp, 1 as bol FROM seg_permissoes p
                        LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                        LEFT JOIN seg_perfis_permissoes pp ON pp.prp_prm_id = p.prm_id
                        WHERE pp.prp_prf_id = ?
                    ) menos ON todas.prm_id = menos.temp";
        $data = array($perfil->mod_id, $idPerfil);
        $perm = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);

        $permissoes = [];
        foreach ($perm as $key => $value) {
            if (isset($permissoes[$value->rcs_id])) {
                $permissoes[$value->rcs_id]['permissoes'][$value->prm_id] = array('prm_id' => $value->prm_id, 'prm_nome' => $value->prm_nome, 'habilitado' => $value->habilitado);
            } else {
                $permissoes[$value->rcs_id]['rcs_id'] = $value->rcs_id;
                $permissoes[$value->rcs_id]['rcs_nome'] = $value->rcs_nome;
                $permissoes[$value->rcs_id]['permissoes'][$value->prm_id] = array('prm_id' => $value->prm_id, 'prm_nome' => $value->prm_nome, 'habilitado' => $value->habilitado);
            }
        }

        return new ViewModel(
            array(
                'perfil' => $perfil,
                'permissoes' => $permissoes
            )
        );
    }
    public function salvarpermissoesperfilAction()
    {
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $post = $request->getPost();
            $perfilId = $post['prf_id'];
            $moduloId = $post['mod_id'];

            $permissoes = $post['permissoes'];

            if (sizeof($permissoes)) {
                $sql = "INSERT INTO seg_perfis_permissoes (`prp_prf_id`, `prp_prm_id`) VALUES ({$perfilId}, {$permissoes[0]})";                
                for ($i=1; $i < sizeof($permissoes); $i++) { 
                    $sql .= ",({$perfilId}, {$permissoes[$i]})";
                }
                $sql .= ";";

                $repository = $this->getDbalConnection();

                $sqlDelete = "DELETE FROM seg_perfis_permissoes WHERE prp_prf_id = ?";
                $dataDelete = array($perfilId);
                $delete = $repository->executeQuery($sqlDelete, $dataDelete);

                $insert = $repository->executeQuery($sql);
            }

            $this->flashMessenger()->setNamespace('success')->addMessage('Permissões atribuidas com sucesso!');
            return $this->redirect()->toUrl('/admin/perfispermissoes');
        }

        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfispermissoes');
        
    }
}