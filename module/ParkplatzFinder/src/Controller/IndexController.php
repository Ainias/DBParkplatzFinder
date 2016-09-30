<?php

namespace ParkplatzFinder\Controller;

use Ainias\Core\Controller\ServiceActionController;
use ParkplatzFinder\Form\SelectTrainStationForm;
use ParkplatzFinder\Model\Manager\OccupancyManager;
use ParkplatzFinder\Model\Occupancy;
use ParkplatzFinder\NoDbModel\ParkplatzFetcher;
use Zend\View\Model\ViewModel;

class IndexController extends ServiceActionController
{
    public function indexAction()
    {
        $parkplatzFetcher = new ParkplatzFetcher();
        $trainStations = $parkplatzFetcher->getStations();
        $trainStationNames = [];
        foreach ($trainStations as $result)
        {
            //Index des Arrays wird später im Form als Value übergeben
            $trainStationNames[$result->bahnhofsNummer] = $result->cityTitle ." - ".$result->station;
        }
        //Erstellen des Formulars innerhalb PHP
        $selectTrainStationForm = new SelectTrainStationForm($trainStationNames);

        //Übergeben der Variablen aus dem Controller an die View
        return new ViewModel(["form" => $selectTrainStationForm]);
    }

    public function getParkingLotsAction()
    {
        $fetchedParkingLots = null;
        $parkplatzFetcher = new ParkplatzFetcher();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $trainStationId = $request->getPost("trainStationId");
            $fetchedParkingLots = $parkplatzFetcher->getParkingLots($trainStationId);
        }

        //Wenn keine Bahnhöfe gefunden werden => keine Infos => 404 zurückgeben
        if ($fetchedParkingLots == null || count($fetchedParkingLots) == 0)
        {
            return $this->triggerDispatchError();
        }

        /** @var OccupancyManager $occupancyManager */
        $occupancyManager = $this->get(OccupancyManager::class);
        $parkingLots = [];
        foreach ($fetchedParkingLots as $parkingLot)
        {
            //Hinzufügen der aktuellen Belegung
            $occupancy = $parkplatzFetcher->getOccupancy($parkingLot->parkraumId);
            if (!isset($occupancy->allocation))
            {
                //Unvollständige Daten der DB, dank Beta REST-API...
                //Eigene Default-Werte für View
                $occupancy = new \stdClass();
                $occupancy->site = new \stdClass();
                $occupancy->site->id = 0;
                $occupancy->site->siteId = $parkingLot->parkraumId;
                $occupancy->site->flaechenNummer = 0;
                $occupancy->site->stationName = $parkingLot->parkraumBahnhofName;
                $occupancy->site->displayName = $parkingLot->parkraumDisplayName;

                $occupancy->allocation = new \stdClass();
                $occupancy->allocation->validData = false;
                $occupancy->allocation->timestamp = "";
                $occupancy->allocation->timeSegment = "";
                $occupancy->allocation->category = 0;
                $occupancy->allocation->text = "---";
            }
            else
            {
                //speichere in die Datenbank, würde bei vielen Anfragen das Fetchen mithilfe des Cronjobs ersetzen
                $occupancyModel = new Occupancy();
                $occupancyModel->setSiteId($occupancy->site->siteId);
                $occupancyModel->setCategory($occupancy->allocation->category);
                $occupancyModel->setTimeSegment(\DateTime::createFromFormat("Y-m-d\\TH:i:s", $occupancy->allocation->timeSegment));
                $occupancyModel->setTimestamp(\DateTime::createFromFormat("Y-m-d\\TH:i:s", $occupancy->allocation->timestamp));
                $occupancyManager->save($occupancyModel);
            }

            //Filterung von außerbetrieblichen Parkplätzen
            if ($parkingLot->parkraumAusserBetriebText == "")
            {
                $parkingLots[$parkingLot->parkraumId] = [
                    "parkingLot" => $parkingLot,
                    "currentOccupancy" => $occupancy,
                    "occupancyPrediction" => $occupancyManager->getOccupancyPrediction($parkingLot->parkraumId),
                ];
            }
        }

        //Da als Ajax nachgeladen nur leeres Layout mit dem Content aus der View anzeigen
        $this->layout("ajax/content");
        return new ViewModel([
            "parkingLots" => $parkingLots,
        ]);
    }
}
