<?php

namespace ParkplatzFinder;

use Ainias\Core\Factory\Controller\ServiceActionControllerFactory;
use ParkplatzFinder\Controller\OccupancyHistoryFetchController;

return array(
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ServiceActionControllerFactory::class,
            OccupancyHistoryFetchController::class => ServiceActionControllerFactory::class,
        ],
    ],
);
