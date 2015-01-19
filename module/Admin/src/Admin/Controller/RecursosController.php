<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Admin\Form\RecursoForm;
use Admin\Entity\Recurso;

class RecursosController extends BaseController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT r.rcs_id, r.rcs_nome, r.rcs_descricao, m.mod_nome, cr.ctr_nome FROM seg_recursos r
                LEFT JOIN seg_modulos m ON m.mod_id = r.rcs_mod_id
                LEFT JOIN seg_categorias_recursos cr ON cr.ctr_id = r.rcs_ctr_id";
        $recursos = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/recursos/create')
             ->setIcon('fa fa-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'recursos' => $recursos
            )
        );
    }
    public function createAction()
    {
        $form = new RecursoForm;
     
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $recurso = new Recurso();
            
            $form->setInputFilter($recurso->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid())
            {

                $recurso->exchangeArray($form->getData());

                $recursoModel = $this->getService("Admin\Model\RecursoModel");

                $recursoModel->save($recurso);

                $this->flashMessenger()->setNamespace('success')->addMessage('Recurso salvo com sucesso!');
                return $this->redirect()->toUrl('/admin/recursos');
            }
        }

        $moduloModel = $this->getService("Admin\Model\ModuloModel");
        $categoriaRecursoModel = $this->getService("Admin\Model\CategoriaRecursoModel");
        //popula o select com os modulos
        $form->get('rcs_mod_id')->setValueOptions($moduloModel->getAllItensToSelect('mod_id', 'mod_nome'));
        $form->get('rcs_ctr_id')->setValueOptions($categoriaRecursoModel->getAllItensToSelect('ctr_id', 'ctr_nome'));

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = new RecursoForm();
        $form->setAttribute('action', '/admin/recursos/update');
        
        // try get method
        if ( $id )
        {
            $recursoRepository = $repository->find('Admin\Entity\Recurso', $id);
            
            if (!$recursoRepository)
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Recurso não existe!');
                return $this->redirect()->toUrl('/admin/recursos');
            } else
            {
                $moduloModel = $this->getService("Admin\Model\ModuloModel");        
                $categoriaRecursoModel = $this->getService("Admin\Model\CategoriaRecursoModel");
                //popula o select com os modulos
                $form->get('rcs_mod_id')->setValueOptions($moduloModel->getAllItensToSelect('mod_id', 'mod_nome'));
                $form->get('rcs_ctr_id')->setValueOptions($categoriaRecursoModel->getAllItensToSelect('ctr_id', 'ctr_nome'));

                $form->setData($recursoRepository->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $recursoEntity = new Recurso();
            $form->setInputFilter($recursoEntity->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $recursoEntity->exchangeArray($form->getData());

                $recursoModel = $this->getService("Admin\Model\RecursoModel");

                $recursoModel->update($recursoEntity, $recursoEntity->rcs_id);

                $this->flashMessenger()->setNamespace('success')->addMessage('Recurso atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/recursos');
            }
        }
        else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/recursos');
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
            $recursoModel = $this->getService("Admin\Model\RecursoModel");

            $recursoModel->delete($id);

            return $this->redirect()->toUrl('/admin/recursos');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/recursos');
    }
}