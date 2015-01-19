<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Admin\Form\PermissaoForm;
use Admin\Entity\Permissao;

use Admin\Model\ModuloModel;
use Admin\Model\RecursoModel;

class PermissoesController extends BaseController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT p.*, rcs_nome, mod_nome FROM seg_permissoes p
                LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                LEFT JOIN seg_modulos m ON m.mod_id = r.rcs_mod_id";
        $permissoes = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/permissoes/create')
             ->setIcon('fa fa-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'permissoes' => $permissoes
            )
        );
    }
    public function createAction()
    {
        $form = new PermissaoForm();

        $form = new PermissaoForm();
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $permissao = new Permissao();

            $form->setInputFilter($permissao->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $permissao->exchangeArray($form->getData());

                $permissaoModel = $this->getService("Admin\Model\PermissaoModel");

                $permissaoModel->save($permissao);

                $this->flashMessenger()->setNamespace('success')->addMessage('Permissão salva com sucesso!');
                return $this->redirect()->toUrl('/admin/permissoes');
            }
        }
        //popula o select com os modulos
        $moduloModel = $this->getService("Admin\Model\ModuloModel");
        $form->get('prm_modulo')->setValueOptions($moduloModel->getAllItensToSelect('mod_id', 'mod_nome'));

        return new ViewModel(
            array('form' => $form)
        );
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = new PermissaoForm();
        $form->setAttribute('action', '/admin/permissoes/update');

        $permissaoModel = $this->getService("Admin\Model\PermissaoModel");

        // try get method
        if ( $id ) {
            $id = (int) $this->params()->fromRoute('id');

            $permissaoData = $permissaoModel->getPermissaoByIdJoinRecursos($id);
            
            if (!$permissaoData) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Permissão não existe!');
                return $this->redirect()->toUrl('/admin/permissoes');
            } else {
                $recursoModel = $this->getService("Admin\Model\RecursoModel");
                $moduloModel = $this->getService("Admin\Model\ModuloModel");

                $modulos = $moduloModel->getAllItensToSelect('mod_id', 'mod_nome');
                $recursos = $recursoModel->getAllItensToSelectByAttributes(array('rcs_mod_id' => $permissaoData['prm_modulo']), 'rcs_id', 'rcs_nome');
                // popula com o select com os recursos
                $form->get('prm_rcs_id')->setValueOptions($recursos);
                $form->get('prm_modulo')->setValueOptions($modulos);

                $form->setData($permissaoData);
            }
        }
        // try post method
        else if ($request->isPost()) {
            $permissao = new Permissao();
            $form->setInputFilter($permissao->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $permissao->exchangeArray($form->getData());                

                $permissaoModel->update($permissao, $permissao->prm_id);

                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Permissão atualizada com sucesso!');
                return $this->redirect()->toUrl('/admin/permissoes');
            }
        }
        else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/permissoes');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        // try get method
        if ( $id )
        {
            $permissaoModel = $this->getService("Admin\Model\PermissaoModel");

            $permissaoModel->delete($id);

            return $this->redirect()->toUrl('/admin/permissoes');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/permissoes');
    }
}
