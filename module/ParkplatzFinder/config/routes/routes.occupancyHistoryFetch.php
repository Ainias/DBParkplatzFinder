<?php

namespace ParkplatzFinder;

use ParkplatzFinder\Controller\OccupancyHistoryFetchController;
use Zend\Mvc\Console\Router\Simple;
use Zend\Router\Http\Segment;

return array(
    'console' => [
        'router' => [
            'routes' => [
                'fetchOccupancy' => [
                    'type' => Simple::class,
                    'options' => [
                        'route'    => 'fetchOccupancy',
                        'defaults' => [
                            'controller' => OccupancyHistoryFetchController::class,
                            'action'     => 'fetchOccupancy',
                        ],
                    ],
                ],
            ],
        ],
    ],
);
