<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class PerfilModel extends BaseModel
{
	public function __construct(){
        $this->setEntity('Admin\Entity\Perfil');
    }
}