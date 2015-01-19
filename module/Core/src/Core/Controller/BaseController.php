<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\DBAL\DriverManager;

class BaseController extends AbstractActionController
{
    protected $entityManager;

    protected function getEntityManager()
    {
    	if (null === $this->entityManager)
    	{
    		$this->entityManager = $this->getService('Doctrine\ORM\EntityManager');
    	}
    	return $this->entityManager;
    }
    protected function getDbalConnection()
    {
    	$config = new \Doctrine\DBAL\Configuration;

    	$params = $this->getService('Config');
    	$params = $params['doctrine']['connection']['orm_default']['params'];

    	return DriverManager::getConnection($params, $config);
    }
    protected function getService($service)
    {
    	return $this->getServiceLocator()->get($service);
    }
    protected function getServiceReport(){
        return $this->getService('Core\Service\ReportService');
    }
}
