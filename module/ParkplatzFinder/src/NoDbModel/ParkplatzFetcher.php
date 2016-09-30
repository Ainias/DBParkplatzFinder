<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 29.09.16
 * Time: 20:06
 */

namespace ParkplatzFinder\NoDbModel;


use Zend\Http\Client;

class ParkplatzFetcher
{
    const BASE_URL = "http://opendata.dbbahnpark.info/api/beta";
    const STATION_URL = self::BASE_URL . "/stations";
    const PARKING_URL = self::BASE_URL . "/sites";
    const OCCUPANCY_URL = self::BASE_URL . "/occupancy";

    /** @var Client */
    private $client;

    /**
     * ParkplatzFetcher constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    private function fetchData()
    {
        $response = $this->client->send();
        $response = json_decode($response->getBody());
        return $response;
    }

    public function getStations()
    {
        $this->client->setUri(self::STATION_URL);
        return $this->fetchData()->results;
    }

    public function getParkingLots($trainStationId = null)
    {
        $this->client->setUri(self::PARKING_URL);
        $results = $this->fetchData()->results;
        if ($trainStationId != null)
        {
            $oldResults = $results;
            $results = [];
            foreach ($oldResults as $oldResult)
            {
                if ($oldResult->parkraumBahnhofNummer == $trainStationId)
                {
                    $results[] = $oldResult;
                }
            }
        }
        return $results;
    }

    public function getOccupancy($parkingLotId = null)
    {
        if ($parkingLotId == null)
        {
            $this->client->setUri(self::OCCUPANCY_URL);
        }
        else
        {
            $this->client->setUri(self::OCCUPANCY_URL."/".$parkingLotId);
        }
        return $this->fetchData();
    }
}