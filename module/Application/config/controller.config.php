<?php

namespace Application;

use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
);