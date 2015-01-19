<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ModuloForm extends Form
{
    public function __construct()
    {
        parent::__construct('novoModulo');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('role','form');
        $this->setAttribute('action', '/admin/modulos/create');

        $mod_id = new Element\Hidden('mod_id');

        $mod_nome = new Element\Text('mod_nome');
        $mod_nome->setName('mod_nome')
                 ->setAttribute('id', 'mod_nome')
                 ->setAttribute('placeholder', 'Nome do módulo')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome do módulo')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $mod_descricao = new Element\Text('mod_descricao');
        $mod_descricao->setName('mod_descricao')
                 ->setAttribute('id', 'mod_descricao')
                 ->setAttribute('placeholder', 'Descrição do módulo')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Descrição do módulo')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $mod_icone = new Element\Text('mod_icone');
        $mod_icone->setName('mod_icone')
                 ->setAttribute('id', 'mod_icone')
                 ->setAttribute('placeholder', 'Ícone do módulo')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Ícone do módulo')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($mod_id)
             ->add($mod_nome)
             ->add($mod_descricao)
             ->add($mod_icone)
             ->add($submit);
    }
}