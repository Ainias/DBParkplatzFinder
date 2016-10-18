<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 30.09.16
 * Time: 05:04
 */

namespace ParkplatzFinder\Controller;


use Ainias\Core\Controller\ServiceActionController;
use ParkplatzFinder\Model\Manager\OccupancyManager;
use ParkplatzFinder\Model\Occupancy;
use ParkplatzFinder\NoDbModel\ParkplatzFetcher;
use Zend\Mvc\Console\View\ViewModel;

class OccupancyHistoryFetchController extends ServiceActionController
{
    public function fetchOccupancyAction()
    {
        //Holen der aktuellen Belegungen
        $parkplatzFetcher = new ParkplatzFetcher();
        $occupancies = $parkplatzFetcher->getOccupancy();

        //Umwandeln und speichern in die DB
        /** @var OccupancyManager $occupancyManager */
        $occupancyManager = $this->get(OccupancyManager::class);
        foreach ($occupancies->allocations as $currentOccupancy) {
            if ($currentOccupancy->allocation->validData) {
                $occupancy = new Occupancy();
                $occupancy->setSiteId($currentOccupancy->site->siteId);
                $occupancy->setCategory($currentOccupancy->allocation->category);
                $occupancy->setTimeSegment(\DateTime::createFromFormat("Y-m-d\\TH:i:s", $currentOccupancy->allocation->timeSegment));
                $occupancy->setTimestamp(\DateTime::createFromFormat("Y-m-d\\TH:i:s", $currentOccupancy->allocation->timestamp));
                $occupancyManager->save($occupancy, false);
            }
        }
        $occupancyManager->emFlush(); //Erst hier flushen => in einer Transaktion

        //Setzt ein leeres Layout
        $this->layout("layout/nothing");

        $viewModel = new ViewModel();
        //Setzt eine Leere View
        $viewModel->setTemplate("layout/nothing");
        return $viewModel;
    }
}