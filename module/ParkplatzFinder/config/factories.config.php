<?php

namespace ParkplatzFinder;

use ParkplatzFinder\Factory\Model\Manager\OccupancyManagerFactory;
use ParkplatzFinder\Model\Manager\OccupancyManager;

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
        ),
        'factories' => array(
            'doctrine.entitymanager.'.__NAMESPACE__ => new \DoctrineORMModule\Service\EntityManagerFactory(__NAMESPACE__),
            'doctrine.connection.'.__NAMESPACE__ => new \DoctrineORMModule\Service\DBALConnectionFactory(__NAMESPACE__),

            OccupancyManager::class => OccupancyManagerFactory::class,
        ),
    ),
);
