<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

use Core\Util\MenuBarButton;
use Admin\Form\UsuarioForm;
use Admin\Entity\Usuario;

class UsuariosController extends BaseController
{

    protected $menuBar = array();

    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Admin\Entity\Usuario');
        $usuarios = $repository->findAll();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/usuarios/create')
             ->setIcon('fa fa-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'usuarios' => $usuarios
            )
        );
    }
    public function createAction()
    {
        $form = new UsuarioForm;
     
        $request = $this->getRequest();

        if ($request->isPost())
        {
            $usuario = new Usuario();
            
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid())
            {
                $usuario->exchangeArray($form->getData());

                $bcrypt = new Bcrypt();
                $usuario->usr_senha = $bcrypt->create($usuario->usr_senha);

                $repository = $this->getEntityManager();
                $repository->persist($usuario);
                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário salvo com sucesso!');
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = new UsuarioForm();
        $form->setAttribute('action', '/admin/usuarios/update');
        
        // try get method
        if ( $id )
        {
            $usuarioRepository = $repository->find('Admin\Entity\Usuario', $id);
            
            if (!$usuarioRepository)
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Usuário não existe!');
                return $this->redirect()->toUrl('/admin/usuarios');
            } else
            {
                $form->setData($usuarioRepository->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $usuario = new Usuario();
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid())
            {
                $usuario->exchangeArray($form->getData());

                $usuarioRepository = $repository->find('Admin\Entity\Usuario', $usuario->usr_id);

                $usuarioRepository->usr_nome = $usuario->usr_nome;
                $usuarioRepository->usr_email = $usuario->usr_email;
                $usuarioRepository->usr_telefone = $usuario->usr_telefone;
                $usuarioRepository->usr_usuario = $usuario->usr_usuario;

                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        }
        else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/usuarios');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();

        // try get method
        if ( $id )
        {
            $usuarioRepository = $repository->find('Admin\Entity\Usuario', $id);
            
            try{
                $repository->remove($usuarioRepository);
                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário excluído com sucesso!');
            } catch(\Doctrine\DBAL\DBALException $e) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir o usuário!');
            }

            return $this->redirect()->toUrl('/admin/usuarios');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');
        return $this->redirect()->toUrl('/admin/usuarios');
    }
}