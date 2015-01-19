<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Admin\Form\PerfilForm;
use Admin\Entity\Perfil;

class PerfisController extends BaseController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT p.*, m.mod_nome FROM seg_perfis p LEFT JOIN seg_modulos m on m.mod_id = p.prf_mod_id";
        $perfis = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/perfis/create')
             ->setIcon('fa fa-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'perfis' => $perfis
            )
        );
    }
    public function createAction()
    {
        $form = new PerfilForm();
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $perfil = new Perfil();

            $form->setInputFilter($perfil->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $perfil->exchangeArray($form->getData());

                $perfilModel = $this->getService("Admin\Model\PerfilModel");

                $perfilModel->save($perfil);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil salvo com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis');
            }
        }

        //popula o select com os modulos
        $moduloModel = $this->getService("Admin\Model\ModuloModel");
        $form->get('prf_mod_id')->setValueOptions($moduloModel->getAllItensToSelect('mod_id', 'mod_nome'));

        return new ViewModel(
            array('form' => $form)
        );
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = new PerfilForm();
        $form->setAttribute('action', '/admin/perfis/update');

        $perfilModel = $this->getService("Admin\Model\PerfilModel");

        // try get method
        if ( $id )
        {
            $perfilData = $perfilModel->getById($id);
            
            if (!$perfilData)
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Perfil não existe!');
                return $this->redirect()->toUrl('/admin/perfis');
            } else
            {
                //popula o select com os modulos
                $moduloModel = $this->getService("Admin\Model\ModuloModel");
                $form->get('prf_mod_id')->setValueOptions($moduloModel->getAllItensToSelect('mod_id', 'mod_nome'));

                $form->setData($perfilData->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $perfilEntity = new Perfil();
            $form->setInputFilter($perfilEntity->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $perfilEntity->exchangeArray($form->getData());

                $perfilModel->update($perfilEntity, $perfilEntity->prf_id);

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/perfis');
            }
        }
        else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/perfis');
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
            $perfilModel = $this->getService("Admin\Model\PerfilModel");
            
            $perfilModel->delete($id);

            return $this->redirect()->toUrl('/admin/perfis');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/perfis');
    }
}
