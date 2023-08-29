<?php

declare(strict_types=1);

namespace Search;

use Application\ServiceManager\Factory\InvokableServiceFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'search' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/search',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'index' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/index',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'result' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/result',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'result',
                            ],
                        ],
                    ],
                    'search' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/search',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'search',
                            ],
                        ],
                    ],
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableServiceFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ELKService::class   => InvokableServiceFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
