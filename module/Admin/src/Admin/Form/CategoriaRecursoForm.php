<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class CategoriaRecursoForm extends Form
{
    public function __construct()
    {
        parent::__construct('novaCategoriaRecurso');
      
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/categoriasrecursos/create');

        $ctr_id = new Element\Hidden('ctr_id');

        $ctr_nome = new Element\Text('ctr_nome');
        $ctr_nome->setName('ctr_nome')
                 ->setAttribute('id', 'ctr_nome')
                 ->setAttribute('placeholder', 'Nome da categoria')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Nome da categoria')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $ctr_descricao = new Element\Text('ctr_descricao');
        $ctr_descricao->setName('ctr_descricao')
                 ->setAttribute('id', 'ctr_descricao')
                 ->setAttribute('placeholder', 'Descrição da categoria')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Descrição da categoria')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $ctr_icone = new Element\Text('ctr_icone');
        $ctr_icone->setName('ctr_icone')
                 ->setAttribute('id', 'ctr_icone')
                 ->setAttribute('placeholder', 'Ícone da categoria')
                 ->setAttribute('class', 'form-control')
                 ->setLabel('Ícone da categoria')
                 ->setLabelAttributes(array('class'=>'col-sm-3 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($ctr_id)
             ->add($ctr_nome)
             ->add($ctr_descricao)
             ->add($ctr_icone)
             ->add($submit);
    }
}