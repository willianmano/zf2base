<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UsuarioForm extends Form
{
    public function __construct()
    {
        parent::__construct('novousuario');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/usuarios/create');

        $usr_id = new Element\Hidden('usr_id');

        $usr_nome = new Element\Text('usr_nome');
        $usr_nome->setName('usr_nome')
                 ->setAttribute('id', 'usr_nome')
                 ->setAttribute('placeholder', 'Nome do usuário')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome do usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $usr_email = new Element\Text('usr_email');
        $usr_email->setName('usr_email')
                 ->setAttribute('id', 'usr_email')
                 ->setAttribute('placeholder', 'Email')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Email')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $usr_telefone = new Element\Text('usr_telefone');
        $usr_telefone->setName('usr_telefone')
                 ->setAttribute('id', 'usr_telefone')
                 ->setAttribute('placeholder', 'Telefone')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Telefone')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $usr_usuario = new Element\Text('usr_usuario');
        $usr_usuario->setName('usr_usuario')
                 ->setAttribute('id', 'usr_usuario')
                 ->setAttribute('placeholder', 'Usuário')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $usr_senha = new Element\Password('usr_senha');
        $usr_senha->setName('usr_senha')
                 ->setAttribute('id', 'usr_senha')
                 ->setAttribute('placeholder', 'Senha')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Senha')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($usr_id)
             ->add($usr_nome)
             ->add($usr_email)
             ->add($usr_telefone)
             ->add($usr_usuario)
             ->add($usr_senha)
             ->add($submit);
    }
}