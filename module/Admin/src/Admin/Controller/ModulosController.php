<?php

namespace Admin\Controller;

use Core\Controller\CRUDController;

use Admin\Form\ModuloForm;
use Admin\Entity\Modulo;

class ModulosController extends CRUDController
{
    public function __construct() {
        $entity = new Modulo;
        $model = 'Admin\Model\ModuloModel';
        $form = new ModuloForm;
        $actionBase = '/admin/modulos';
        $label = 'Módulo';
        
        parent::__construct($entity, $model, $form, $actionBase, $label);
    }
}