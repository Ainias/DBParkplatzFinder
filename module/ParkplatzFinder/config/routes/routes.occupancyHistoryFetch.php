<?php

namespace ParkplatzFinder;

use ParkplatzFinder\Controller\OccupancyHistoryFetchController;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'fetchOccupancy' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/fetchOccupancy',
                    'defaults' => [
                        'controller' => OccupancyHistoryFetchController::class,
                        'action'     => 'fetchOccupancy',
                        'resource' => 'default',
                    ],
                ],
            ],
        ],
    ],
);
