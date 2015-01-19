<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class CategoriaRecursoModel extends BaseModel
{
    public function __construct(){
        $this->setEntity('Admin\Entity\CategoriaRecurso');
    }
}