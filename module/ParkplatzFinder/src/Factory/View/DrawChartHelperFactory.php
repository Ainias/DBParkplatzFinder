<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 30.09.16
 * Time: 08:22
 */

namespace ParkplatzFinder\Factory\View;


use Interop\Container\ContainerInterface;
use ParkplatzFinder\View\DrawChartHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

class DrawChartHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get("config");
        return new DrawChartHelper($config["systemVariables"]["numberTimeSegmentsPerDay"]);
    }

}