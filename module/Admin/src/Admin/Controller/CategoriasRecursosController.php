<?php

namespace Admin\Controller;

use Core\Controller\CRUDController;

use Admin\Form\CategoriaRecursoForm;
use Admin\Entity\CategoriaRecurso;

class CategoriasRecursosController extends CRUDController
{
    public function __construct() {
        $entity = new CategoriaRecurso;
        $model = 'Admin\Model\CategoriaRecursoModel';
        $form = new CategoriaRecursoForm;
        $actionBase = '/admin/categoriasrecursos';
        $label = 'Categoria de Recurso';
        
        parent::__construct($entity, $model, $form, $actionBase, $label);
    }
}