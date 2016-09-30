<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ParkplatzFinder;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        $config = array();
        foreach (glob(__DIR__ . '/../config/*.config.php') as $filename) {
            $config = array_merge_recursive($config, include($filename));
        }
        return $config;
    }
}
