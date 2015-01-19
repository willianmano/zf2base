<?php

namespace Admin\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
	public function indexAction()
    {
        return new ViewModel();
    }
}