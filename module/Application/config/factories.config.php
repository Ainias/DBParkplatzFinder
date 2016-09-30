<?php
namespace Application;

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'doctrine.entitymanager.' . __NAMESPACE__ => new \DoctrineORMModule\Service\EntityManagerFactory(__NAMESPACE__),
            'doctrine.connection.' . __NAMESPACE__ => new \DoctrineORMModule\Service\DBALConnectionFactory(__NAMESPACE__),
            'doctrine.configuration.' . __NAMESPACE__ => new \DoctrineORMModule\Service\ConfigurationFactory(__NAMESPACE__),
        ),
    ),
);