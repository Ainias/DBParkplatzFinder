<?php

namespace ParkplatzFinder;

use ParkplatzFinder\Factory\View\DrawChartHelperFactory;
use ParkplatzFinder\View\DrawChartHelper;

return array(
    'view_helpers' => array(
        'factories' => array(
            DrawChartHelper::class => DrawChartHelperFactory::class,
        ),
        'aliases' => [
            'drawPredictionChart' => DrawChartHelper::class,
        ],
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
    ),
);
