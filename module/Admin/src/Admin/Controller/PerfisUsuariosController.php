<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;

class PerfisUsuariosController extends BaseController
{
    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Admin\Entity\Usuario');
        $usuarios = $repository->findAll();

        return new ViewModel(
            array(
                'usuarios' => $usuarios
            )
        );
    }
    public function gerenciarperfisusuarioAction()
    {
        $idUsuario = (int) $this->params()->fromRoute('id');

        $repository = $this->getDbalConnection();

        $sql = "SELECT p.* FROM seg_perfis p
                LEFT JOIN seg_perfis_usuarios pu ON pu.pru_prf_id = p.prf_id
                LEFT JOIN seg_usuarios u ON u.usr_id = pu.pru_usr_id
                WHERE u.usr_id = ?";
        $data = array($idUsuario);
        $usuarioPerfis = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);

        $sql = "SELECT usr_id, usr_nome FROM seg_usuarios WHERE usr_id = ?";
        $data = array($idUsuario);
        $usuario = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS)[0];

        $sql = "SELECT mod_id, mod_nome
                FROM seg_modulos
                WHERE
                 mod_id NOT IN (
                    SELECT prf_mod_id
                        FROM seg_perfis
                        WHERE prf_id IN (
                            SELECT pru_prf_id
                            FROM seg_usuarios u
                            LEFT JOIN seg_perfis_usuarios pu ON pu.pru_usr_id = u.usr_id
                            WHERE u.usr_id = ?
                        )
                )";
        $data = array($idUsuario);
        $modulos = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);

        return new ViewModel(
            array(
                'usuario' => $usuario,
                'usuarioPerfis' => $usuarioPerfis,
                'modulos' => $modulos,
            )
        );
    }
    public function deleteAction()
    {
        $idUsuario = (int) $this->params()->fromRoute('id');
        $idPerfil = (int) $this->params()->fromRoute('idtwo');

        // try get method
        if ( $idUsuario != 0 && $idPerfil != 0 )
        {
            try{
                $sql = "DELETE FROM seg_perfis_usuarios WHERE pru_usr_id = ? AND pru_prf_id = ?";
                $data = array($idUsuario, $idPerfil);

                $repository = $this->getDbalConnection();
                $repository->executeQuery($sql, $data);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil excluído com sucesso!');
            } catch(\Doctrine\DBAL\DBALException $e) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir o perfil!');
            }
            return $this->redirect()->toUrl('/admin/perfisusuarios/gerenciarperfisusuario/' . $idUsuario);
        }

        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfisusuarios');
    }
    public function atribuirperfilusuarioAction()
    {
        $idUsuario = (int) $this->params()->fromRoute('id');
        $idPerfil = (int) $this->params()->fromRoute('idtwo');

        if ( $idUsuario != 0 && $idPerfil != 0 )
        {
            try{
                $sql = "INSERT INTO seg_perfis_usuarios (`pru_usr_id`, `pru_prf_id`) VALUE (?,?)";
                $data = array($idUsuario, $idPerfil);

                $repository = $this->getDbalConnection();
                $repository->executeQuery($sql, $data);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil Atribuído com sucesso!');
            } catch(\Doctrine\DBAL\DBALException $e) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível atribuir o perfil!');
            }
            return $this->redirect()->toUrl('/admin/perfisusuarios/gerenciarperfisusuario/' . $idUsuario);
        }

        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfisusuarios');
    }
}