<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return [
    'dbDefault' => array(
        'user' => "",
        'password' => "",
        'host' => '',
        'dbname' => '',
        'driverOptions' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ),
        'useStrict' => true,
    ),
    'mailEinstellungen' => array(
        'options' => array(
            'name' => '',
            'host' => '',
            'port' => '587',
            'connection_class' => 'plain', // plain oder login
            'connection_config' => array(
                'username' => '',
                'password' => '',
                'ssl' => '',
            ),
        ),
        'sender' => '',
    ),

    'systemvariablen' => array(
        'timePeriodForPredictionInDays' => 7*5,
        'numberTimeSegmentsPerDay' => 60*24/90, //alle 90 min
    ),
];
