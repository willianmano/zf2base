<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class RecursoForm extends Form
{
    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoRecurso');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/recursos/create');

        $rcs_id = new Element\Hidden('rcs_id');

        $rcs_mod_id = new Element\Select('rcs_mod_id');
        $rcs_mod_id->setName('rcs_mod_id')
                 ->setAttribute('id', 'rcs_mod_id')
                 ->setAttribute('placeholder', 'Módulo do recurso')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Módulo do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $rcs_ctr_id = new Element\Select('rcs_ctr_id');
        $rcs_ctr_id->setName('rcs_ctr_id')
                 ->setAttribute('id', 'rcs_ctr_id')
                 ->setAttribute('placeholder', 'Categoria do recurso')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Categoria do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'))
                 ->setEmptyOption('Escolha uma categoria');

        $rcs_nome = new Element\Text('rcs_nome');
        $rcs_nome->setName('rcs_nome')
                 ->setAttribute('id', 'rcs_nome')
                 ->setAttribute('placeholder', 'Nome do recurso')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $rcs_descricao = new Element\Text('rcs_descricao');
        $rcs_descricao->setName('rcs_descricao')
                 ->setAttribute('id', 'rcs_descricao')
                 ->setAttribute('placeholder', 'Descrição do recurso')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Descrição do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $rcs_icone = new Element\Text('rcs_icone');
        $rcs_icone->setName('rcs_icone')
                 ->setAttribute('id', 'rcs_icone')
                 ->setAttribute('placeholder', 'Ícone do recurso')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Ícone do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($rcs_id)
             ->add($rcs_mod_id)
             ->add($rcs_ctr_id)
             ->add($rcs_nome)
             ->add($rcs_descricao)
             ->add($rcs_icone)
             ->add($submit);
    }
}