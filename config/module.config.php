<?php

namespace BplUser;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\AuthenticationController::class => Controller\Factory\AuthenticationControllerFactory::class,
            Controller\RegisterController::class => Controller\Factory\RegisterControllerFactory::class,
            Controller\ForgotController::class =>   Controller\Factory\ForgotPasswordControllerFactory::class,
            Controller\ChangeEmailController::class => Controller\Factory\ChangeEmailControllerFactory::class,
            Controller\ChangePasswordController::class => Controller\Factory\ChangePasswordControllerFactory::class,
            Controller\ChangeProfileController::class => Controller\Factory\ChangeProfileControllerFactory::class,
        ],
        
    ],
    'controller_plugins' => [
        'factories' => [
            'bpluser' => Controller\Factory\BplUserControllerPluginFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Options\ModuleOptions::class => Options\Factory\ModuleOptionsFactory::class,
            Service\BplUserService::class => Service\Factory\BplUserServiceFactory::class,
            Form\ChangePassword::class => Form\Factory\ChangePasswordFormFactory::class,
            Form\ChangeProfile::class => Form\Factory\ChangeProfileFormFactory::class,
            Form\Forgot::class => Form\Factory\ForgotFormFactory::class,
            Form\ResetPassword::class => Form\Factory\ResetPasswordFactory::class,
            Form\Login::class => Form\Factory\LoginFormFactory::class,
            Form\Register::class => Form\Factory\RegisterFormFactory::class,
            Form\ChangeEmail::class => Form\Factory\ChangeEmailFormFactory::class,
            Form\ChangePassword::class => Form\Factory\ChangePasswordFormFactory::class,
            Form\ChangeProfile::class => Form\Factory\ChangeProfileFormFactory::class,
            Collector\BplUserCollector::class => Collector\Factory\BplUserCollectorFactory::class,
            Mapper\UserPasswordResetMapper::class => Mapper\Factory\UserPasswordResetMapperFactory::class,
            Listener\UserEntityListener::class => Listener\Factory\UserEntityListenerFactory::class
        ],
    ],
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    \BplUser\Listener\UserEntityListener::class
                ],
            ],
        ],
        
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/Entity',
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'bpl-user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login',
                            'defaults' => [
                                'controller' => Controller\AuthenticationController::class,
                                'action' => 'login',
                            ],
                        ],
                    ],
                    'register' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/register',
                            'defaults' => [
                                'controller' => Controller\RegisterController::class,
                                'action' => 'register',
                            ],
                        ],
                    ],
                    'change-email' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/change-email',
                            'defaults' => [
                                'controller' => Controller\ChangeEmailController::class,
                                'action' => 'change-email',
                            ],
                        ],
                    ],
                    'change-password' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/change-password',
                            'defaults' => [
                                'controller' => Controller\ChangePasswordController::class,
                                'action' => 'change-password',
                            ],
                        ],
                    ],
                    'change-profile' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/change-profile',
                            'defaults' => [
                                'controller' => Controller\ChangeProfileController::class,
                                'action' => 'change-profile',
                            ],
                        ],
                    ],
                    'forgot-password' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/forgot-password',
                            'defaults' => [
                                'controller' => Controller\ForgotController::class,
                                'action' => 'forgot-password',
                            ],
                        ],
                    ],
                    'reset-password' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/reset-password/[:userId]/[:token]',
                            'defaults' => [
                                'controller' => Controller\ForgotController::class,
                                'action' => 'reset-password',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/logout',
                            'defaults' => [
                                'controller' => Controller\AuthenticationController::class,
                                'action' => 'logout',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'circlical' => [
        'user' => [
            'guards' => [
                'BplUser' => [
                    'controllers' => [
                        Controller\AuthenticationController::class => [
                            'default' => [],
                            'actions' => [
                                'index' => ['user'],
                                'logout' => ['user'],
                            ],
                        ],
                        Controller\ChangeEmailController::class => [
                            'actions' => [
                                'change-email' => ['user'],
                            ],
                        ],
                        Controller\ChangePasswordController::class => [
                            'actions' => [
                                'change-password' => ['user'],
                            ],
                        ],
                        Controller\ChangeProfileController::class => [
                            'actions' => [
                                'change-profile' => ['user'],
                            ],
                        ],
                        Controller\ForgotController::class => [
                            'default' => [],
                        ],
                        Controller\RegisterController::class => [
                            'default' => [],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'bpl-user' => __DIR__ . '/../view',
        ],
        'template_map' => [
            'user/401' => __DIR__ . '/../view/bpl-user/authentication/401.phtml',
            'user/403' => __DIR__ . '/../view/bpl-user/authentication/403.phtml',
            'bpl-user/generic-form' => __DIR__ . '/../view/bpl-user/form/_form.phtml',
            'bpl-user/registration-email-template' => __DIR__ . '/../view/bpl-user/register/register-email.phtml',
            'bpl-user/forgot-password-email-template' => __DIR__ . '/../view/bpl-user/forgot/forgot-password-email.phtml',
            'zend-developer-tools/toolbar/bpl-user-data' => __DIR__ . '/../view/zend-developer-tools/toolbar/bpl-user-data.phtml',
        ]
    ],
    'zenddevelopertools' => [
        'profiler' => [
            'collectors' => [
                Collector\BplUserCollector::class => Collector\BplUserCollector::class,
            ],
        ],
        'toolbar' => [
            'entries' => [
                Collector\BplUserCollector::class => 'zend-developer-tools/toolbar/bpl-user-data',
            ],
        ],
    ],
];
