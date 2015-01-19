<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PermissaoForm extends Form
{
    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novaPermissao');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/permissoes/create');

        $prm_id = new Element\Hidden('prm_id');

        $prm_modulo = new Element\Select('prm_modulo');
        $prm_modulo->setName('prm_modulo')
                 ->setAttribute('placeholder', 'Módulo do recurso')
                 ->setAttribute('id', 'prm_modulo')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Módulo do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $prm_rcs_id = new Element\Select('prm_rcs_id');
        $prm_rcs_id->setName('prm_rcs_id')
                 ->setAttribute('placeholder', 'Recurso da permissão')
                 ->setAttribute('id', 'prm_rcs_id')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Recurso da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'))
                 ->setEmptyOption('Escolha um recurso');

        $prm_nome = new Element\Text('prm_nome');
        $prm_nome->setName('prm_nome')
                 ->setAttribute('id', 'prm_nome')
                 ->setAttribute('placeholder', 'Nome da Permissão')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $prm_descricao = new Element\Text('prm_descricao');
        $prm_descricao->setName('prm_descricao')
                 ->setAttribute('id', 'prm_descricao')
                 ->setAttribute('placeholder', 'Descrição da Permissão')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Descrição da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($prm_id)
             ->add($prm_modulo)
             ->add($prm_rcs_id)
             ->add($prm_nome)
             ->add($prm_descricao)
             ->add($submit);
    }
}