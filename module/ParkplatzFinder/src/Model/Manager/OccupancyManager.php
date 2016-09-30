<?php

namespace ParkplatzFinder\Model\Manager;

use Ainias\Core\Model\Manager\StandardManager;
use ParkplatzFinder\Model\Repository\OccupancyRepository;
use ParkplatzFinder\Model\Occupancy;

class OccupancyManager extends StandardManager
{
    /** @var OccupancyRepository  */
    protected $repository;

    protected $timePeriodForPrediction;

    protected $numberTimeSegments;

    public function __construct(OccupancyRepository $repository, $timePeriodForPrediction, $numberTimeSegments, Occupancy $entity = null)
    {
        $this->repository = $repository;
        $this->timePeriodForPrediction = $timePeriodForPrediction;
        $this->numberTimeSegments = $numberTimeSegments;
        parent::__construct($repository, $entity);
    }

    public function getOccupancyPrediction($sideId)
    {
        $time = new \DateTime();
        $time->sub(new \DateInterval("P".$this->timePeriodForPrediction."D"));
        $occupancies = $this->repository->getOccupancyForPrediction($sideId, $time);
        $minutesPerSegment = 60*24/$this->numberTimeSegments;

        //Index für jeden Wochentag
        $prediction = [
            0 => [],
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
        ];
        /** @var Occupancy $occupancy */
        foreach ($occupancies as $occupancy)
        {
            //Zuerst in Unix-Timestamp, danach Modulo (60*60*24) => Filterung der Uhrzeit, Datum ist weg
            //Danach / 60 um die Sekunden in Minuten umzurechen
            //Danach /MinutenPerSegment um die Segmentnummer herauszubekommen
            //Danach intval um eventuelle Kommawerte loszuwerden
            $numberSegment = intval((($occupancy->getTimeSegment()->getTimestamp()%(60*60*24))/60)/$minutesPerSegment);
            $prediction[$occupancy->getTimeSegment()->format("w")][$numberSegment][] = $occupancy->getCategory();
        }
        foreach ($prediction as &$dayPrediction)
        {
            foreach ($dayPrediction as &$timeSegmentPrediction)
            {
                $timeSegmentPrediction = array_sum($timeSegmentPrediction)/count($timeSegmentPrediction);
            }
        }
        return $prediction;
    }

    /**
     * @param int $id
     * @return Occupancy
     */
    public function getEntityById($id)
    {
        return parent::getEntityById($id);
    }
}