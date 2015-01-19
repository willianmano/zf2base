<?php

namespace Demeter;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            MvcEvent::EVENT_DISPATCH,
            array($this, 'controllerPreDispatch'),
            200
        );
    }

    public function controllerPreDispatch($e)
    {
        $serviceLocator = $e->getTarget()->getServiceLocator();
        $routeMatch = $e->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');

        $controllerName = $routeMatch->getParam('controller');
        $controllerName = explode("\\", $controllerName);
        $controllerName = strtolower($controllerName[2]);

        $actionName = strtolower($routeMatch->getParam('action'));

        $enabledPermissions = $e->getApplication()->getServiceManager()->get('Config');
        $enabledPermissions = $enabledPermissions['access_control'];

        $openActions = array_merge_recursive($enabledPermissions['preloginopenactions'],$enabledPermissions['postloginopenactions']);

        $isOpennedAction = false;
        if ( !is_null($openActions[$moduleName][$controllerName])) {
            $isOpennedAction = array_search($actionName, $openActions[$moduleName][$controllerName]);
        }

        if($isOpennedAction === false || is_null($isOpennedAction)) {
            if ($controllerName != 'async') {

                $demeterService = $e->getApplication()->getServiceManager()->get('Demeter\Service\DemeterService');
                
                $modulo = $demeterService->persistModulo($moduleName);
                $recurso = $demeterService->persistRecurso($controllerName, $modulo->mod_id);
                $permissao = $demeterService->persistPermissao($actionName, $recurso->rcs_id);

                // atribui a permissao ao perfil do modulo. Caso nao tenho nenhum cria um perfil
                $perfilPermissao = $demeterService->persistPerfilPermissao($permissao->prm_id, $modulo->mod_id);
            }
        }
        
        return true;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
