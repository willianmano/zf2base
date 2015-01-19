<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Session' => function($serviceManager) {
                return new Zend\Session\Container('zf2base');
            },
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            // 'Core\Service\AuthService' => function($serviceManager) {
            //     $authService = $serviceManager->get('Zend\Authentication\AuthenticationService');
            //     return new Core\Service\AuthService($authService);
            // },
            // 'Zend\Authentication\AuthenticationService' => function($serviceManager) {
            //     return $serviceManager->get('doctrine.authenticationservice.orm_default');
            // },
        ),
        'invokables' => array(
            'Core\Service\AuthorizationService' => 'Core\Service\AuthorizationService',
            'Core\Service\AuthService' => 'Core\Service\AuthService',
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'flashMessage' => function($serviceManager) {
                $flashmessenger = $serviceManager->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger');
                $message = new Core\View\Helper\FlashMessages();
                $message->setFlashMessenger( $flashmessenger );

                return $message ;
            }
        ),
        'invokables'=> array(
            'session' => 'Core\View\Helper\Session',
            'menuBar' => 'Core\View\Helper\MenuBar',
            'elementToRow' => 'Core\View\Helper\ElementToRow'
        ),
    ),
    
);
