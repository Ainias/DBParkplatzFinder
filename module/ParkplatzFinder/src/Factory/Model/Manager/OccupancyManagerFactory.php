<?php

namespace ParkplatzFinder\Factory\Model\Manager;

use ParkplatzFinder\Model\Occupancy;
use ParkplatzFinder\Model\Manager\OccupancyManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class OccupancyManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get("config");
        $em = $container->get('doctrine.entitymanager.ParkplatzFinder');
        return new OccupancyManager($em->getRepository(Occupancy::class), $config["systemVariables"]["timePeriodForPredictionInDays"],$config["systemVariables"]["numberTimeSegmentsPerDay"]);
    }
} 