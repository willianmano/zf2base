<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PerfilForm extends Form
{
    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoPerfil');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/perfis/create');

        $prf_id = new Element\Hidden('prf_id');

        $prf_mod_id = new Element\Select('prf_mod_id');
        $prf_mod_id->setName('prf_mod_id')
                 ->setAttribute('id', 'prf_mod_id')
                 ->setAttribute('placeholder', 'Módulo do perfil')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Módulo do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $prf_nome = new Element\Text('prf_nome');
        $prf_nome->setName('prf_nome')
                 ->setAttribute('id', 'prf_nome')
                 ->setAttribute('placeholder', 'Nome do perfil')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $prf_descricao = new Element\Text('prf_descricao');
        $prf_descricao->setName('prf_descricao')
                 ->setAttribute('id', 'prf_descricao')
                 ->setAttribute('placeholder', 'Descrição do perfil')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Descrição do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($prf_id)
             ->add($prf_mod_id)
             ->add($prf_nome)
             ->add($prf_descricao)
             ->add($submit);
    }
}