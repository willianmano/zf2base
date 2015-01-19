<?php

namespace Core\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;

class CRUDController extends BaseController
{
    
    protected $menuBar = array();

    protected $entity;
    protected $form;
    protected $actionBase;
    protected $label;
    protected $model;

    function __construct($entity, $model, $form, $actionBase, $label) {
        $this->entity = $entity;
        $this->model = $model;
        $this->form = $form;
        $this->actionBase = $actionBase;
        $this->label = $label;
    }

    protected function getModel() {
        if(!is_object($this->model)) {
            $this->model = $this->getService($this->model);
        }

        return $this->model;
    }

    public function indexAction() {
        $resultSet = $this->getModel()->findAll();
        
        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction($this->actionBase . '/create')
             ->setIcon('fa fa-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'resultSet' => $resultSet
            )
        );
    }
    
    public function createAction() {
        $form = $this->form;
     
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $dataObject = $this->entity;
            
            $form->setInputFilter($dataObject->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid())
            {
                $dataObject->exchangeArray($form->getData());

                $this->getModel()->save($dataObject);

                $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' salvo com sucesso!');
                return $this->redirect()->toUrl($this->actionBase);
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function updateAction() {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = $this->form;
        $form->setAttribute('action', $this->actionBase . '/update');
        
        // try get method
        if ( $id )
        {
            $myRepository = $this->getModel()->getById($id);
             
            if (!$myRepository)
            {
                $this->flashMessenger()->setNamespace('error')->addMessage($this->label . ' não existe!');
                return $this->redirect()->toUrl($this->actionBase);
            } else
            {
                $form->setData($myRepository->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $dataObject = $this->entity;

            $form->setInputFilter($dataObject->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $dataObject->exchangeArray($form->getData());

                $this->getModel()->update($dataObject, $dataObject->getId());

                $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' atualizado com sucesso!');
                return $this->redirect()->toUrl($this->actionBase);
            }
        }
        else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl($this->actionBase);
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id');
        
        // try get method
        if ( $id )
        {
            $this->getModel()->delete($id);

            $this->flashMessenger()->setNamespace('success')->addMessage($this->label . ' excluído com sucesso!');
            
            return $this->redirect()->toUrl($this->actionBase);
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl($this->actionBase);
    }
}