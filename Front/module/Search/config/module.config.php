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
                    'add-path' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/add-path',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'search',
                            ],
                        ],
                    ],
                    'show-path' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/show-path',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'search',
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
            // 'Laminas\View\Model\ViewModel' => 'Laminas\View\Model\ViewModelFactory',
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'search' => __DIR__.'/../view',
        ],
    ],
];
