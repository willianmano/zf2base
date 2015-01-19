<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class ModuloModel extends BaseModel
{
    public function __construct(){
        $this->setEntity('Admin\Entity\Modulo');
    }
}