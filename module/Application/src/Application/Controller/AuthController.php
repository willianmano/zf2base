<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\BaseController;
use Application\Form\Login;

class AuthController extends BaseController
{
    public function indexAction()
    {
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso proibido!');
            return $this->redirect()->toUrl('/application/auth');
        }
        
        $data = $request->getPost();
        $service = $this->getService('Core\Service\AuthService');
        $auth = $service->authenticate(
            array(
            'usr_usuario' => $data['usr_usuario'],
            'usr_senha' => $data['usr_senha']
            )
        );

        if ( $auth ) {
            return $this->redirect()->toUrl('/');
        } else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Usuário e/ou senha inválido(s)');
            return $this->redirect()->toUrl('/application/auth');
        }
    }

    public function logoutAction()
    {
        $service = $this->getService('Core\Service\AuthService');
        $auth = $service->logout();

        return $this->redirect()->toUrl('/');
    }
}