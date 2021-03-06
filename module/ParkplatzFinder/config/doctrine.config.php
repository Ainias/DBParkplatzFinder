<?php

namespace ParkplatzFinder;

use Ainias\Core\Connections\MyConnection;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return array(
    'doctrine' => array(
        'connection' => array(
            __NAMESPACE__ => array(
                'wrapperClass' => MyConnection::class,
                'params' => array(
//                    'dbname' => 'silas_'.__NAMESPACE__,
                )
            )
        ),
        'driver' => array(
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__.'\Model' => 'entities_'.__NAMESPACE__
                ),
            ),
            'entities_'.__NAMESPACE__ => array(
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Model',
                )
            )
        ),
        'entitymanager' => array(
            __NAMESPACE__ => array(
                'connection' => __NAMESPACE__,
            )
        ),
    ),
);
