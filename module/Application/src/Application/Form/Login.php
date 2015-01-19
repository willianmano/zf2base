<?php

namespace Application\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct('login');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/application/auth/login');
        $this->add(array(
            'name' => 'usr_usuario',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Usuário',
                'class' => 'form-control'
            ),
        ));
        $this->add(array(
            'name' => 'usr_senha',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Senha',
                'class' => 'form-control'
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }
}