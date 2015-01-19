<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\JsonModel;

class AsyncController extends BaseController
{
    public function getRecursosByModuloIdAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $recursoModel = $this->getService("Admin\Model\RecursoModel");

        $recursos = $recursoModel->getAllItensToSelectByAttributesJsonReturn(array('rcs_mod_id' => $id), 'rcs_id', 'rcs_nome');

        $result = new JsonModel($recursos);

        return $result;
    }
    public function getPerfisByModuloIdAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $perfilModel = $this->getService("Admin\Model\PerfilModel");
        
        $perfis = $perfilModel->getAllItensToSelectByAttributesJsonReturn(array('prf_mod_id' => $id), 'prf_id', 'prf_nome');

        $result = new JsonModel($perfis);

        return $result;
    }
}