<?php

namespace ParkplatzFinder\Model\Repository;

use Ainias\Core\Model\Repository\StandardRepository;
use ParkplatzFinder\Model\Occupancy;

class OccupancyRepository extends StandardRepository
{
    public function getOccupancyForPrediction($sideId, $firstTime)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select("o")->from(Occupancy::class, "o");
        $queryBuilder->where("o.siteId = :siteId AND o.timeSegment >= :firstTime");
        $queryBuilder->setParameter("siteId", $sideId);
        $queryBuilder->setParameter("firstTime", $firstTime);
        $queryBuilder->orderBy("o.timeSegment");
        return $result = $queryBuilder->getQuery()->execute();
    }
}