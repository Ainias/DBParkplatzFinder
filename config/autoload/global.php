<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Zend\Session;

return [
    'db' => array(
        'driver' => 'Pdo',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
            ),
        ),
    ),

    'session_config' => array(
        'options' => array(
            'name' => 'silasLinkId',
            'cookie_httponly' => true,
        ),
//        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
//        'validators' =>
    ),
    'session_storage' => array(
        'type' => Session\Storage\SessionArrayStorage::class,
    ),
    'session_validators' => array(
        'Zend\Session\Validator\RemoteAddr',
        'Zend\Session\Validator\HttpUserAgent',
    ),

    'session' => [
        'config' => [
            'class' => Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'myapp',
            ],
        ],
        'storage' => Session\Storage\SessionArrayStorage::class,
        'validators' => [
//            Session\Validator\RemoteAddr::class,
//            Session\Validator\HttpUserAgent::class,
        ],
    ],
];
