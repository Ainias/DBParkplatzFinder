<?php

namespace ParkplatzFinder;

use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'parkplatzFinder' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'resource' => 'default',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'getParkingLots' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/getParkingLots',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'getParkingLots',
                                'resource' => 'default',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
);
