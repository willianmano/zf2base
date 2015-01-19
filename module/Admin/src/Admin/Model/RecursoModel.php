<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class RecursoModel extends BaseModel
{
    public function __construct(){
        $this->setEntity('Admin\Entity\Recurso');
    }
}