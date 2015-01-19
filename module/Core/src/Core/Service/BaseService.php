<?php
namespace Core\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Doctrine\DBAL\DriverManager;

abstract class BaseService implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    protected $entityManager;
    
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
    public function getService($service)
    {
        return $this->getServiceManager()->get($service);
    }
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

        $params = $this->getServiceManager()->get('Config');
        $params = $params['doctrine']['connection']['orm_default']['params'];

        return DriverManager::getConnection($params, $config);
    }
}