<?php

// module/Admin/conﬁg/module.config.php:

namespace Admin;

return array(
    'service_manager' => array(
        'invokables' => array(
            'Admin\Model\ModuloModel' => 'Admin\Model\ModuloModel',
            'Admin\Model\RecursoModel' => 'Admin\Model\RecursoModel',
            'Admin\Model\PerfilModel' => 'Admin\Model\PerfilModel',
            'Admin\Model\PermissaoModel' => 'Admin\Model\PermissaoModel',
            'Admin\Model\CategoriaRecursoModel' => 'Admin\Model\CategoriaRecursoModel',
        ),
    ),
    'controllers' => array( //add module controllers
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Modulos' => 'Admin\Controller\ModulosController',
            'Admin\Controller\Usuarios' => 'Admin\Controller\UsuariosController',
            'Admin\Controller\Perfis' => 'Admin\Controller\PerfisController',
            'Admin\Controller\Recursos' => 'Admin\Controller\RecursosController',
            'Admin\Controller\CategoriasRecursos' => 'Admin\Controller\CategoriasRecursosController',
            'Admin\Controller\Permissoes' => 'Admin\Controller\PermissoesController',
            'Admin\Controller\Async' => 'Admin\Controller\AsyncController',
            'Admin\Controller\PerfisPermissoes' => 'Admin\Controller\PerfisPermissoesController',
            'Admin\Controller\PerfisUsuarios' => 'Admin\Controller\PerfisUsuariosController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'module'        => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action][/:id][/:idtwo]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]+',
                                'idtwo'      => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        // 'child_routes' => array( //permite mandar dados pela url 
                        //     'wildcard' => array(
                        //         'type' => 'Wildcard'
                        //     ),
                        // ),
                    ),
                    
                ),
            ),
        ),
    ),
    'module_layout' => array(
        'Admin' => 'layout/layout_admin.phtml'
    ),
    'view_manager' => array( //the module can have a specific layout
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'navigation' => array(
         'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
                'pages' => array(
                    array(
                        'label' => 'Admin',
                        'route' => 'admin',
                        'pages' => array(
                            //Modulos
                            array(
                                'label' => 'Módulos',
                                'controller' => 'modulos',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'modulos',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'modulos',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Usuarios
                            array(
                                'label' => 'Usuários',
                                'controller' => 'usuarios',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'usuarios',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'usuarios',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Perfis
                            array(
                                'label' => 'Perfis',
                                'controller' => 'perfis',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'perfis',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'perfis',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Recursos
                            array(
                                'label' => 'Recursos',
                                'controller' => 'recursos',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'recursos',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'recursos',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Recursos
                            array(
                                'label' => 'Categorias de Recursos',
                                'controller' => 'categoriasrecursos',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'categoriasrecursos',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'categoriasrecursos',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Permissoes
                            array(
                                'label' => 'Permissoes',
                                'controller' => 'permissoes',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Novo',
                                        'controller' => 'permissoes',
                                        'action' => 'create',
                                    ),
                                    array(
                                        'label' => 'Atualizar',
                                        'controller' => 'permissoes',
                                        'action' => 'update',
                                    )
                                )
                            ),
                            //Permissoes
                            array(
                                'label' => 'Perfis Permissoes',
                                'controller' => 'perfispermissoes',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Atribuir permissões ao perfil',
                                        'controller' => 'perfispermissoes',
                                        'action' => 'atribuirpermissoesperfil',
                                    )
                                )
                            ),
                            //Permissoes
                            array(
                                'label' => 'Perfis Usuários',
                                'controller' => 'perfisusuarios',
                                'action' => 'index',
                                'pages' => array(
                                    array(
                                        'label' => 'Gerenciar perfis do usuário',
                                        'controller' => 'perfisusuarios',
                                        'action' => 'gerenciarperfisusuario',
                                    ),
                                )
                            ),
                        )
                    )
                )
            )
        )
    ),
);