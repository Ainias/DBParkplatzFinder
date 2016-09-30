<?php

namespace ParkplatzFinder\Model;

use Ainias\Core\Model\StandardModel;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity(repositoryClass="ParkplatzFinder\Model\Repository\OccupancyRepository")
 */
class Occupancy extends StandardModel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $siteId;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $category;

    /** @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $timeSegment;

    /** @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * Occupancy constructor.
     */
    public function __construct()
    {
        $this->id = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param int $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return \DateTime
     */
    public function getTimeSegment()
    {
        return $this->timeSegment;
    }

    /**
     * @param \DateTime $timeSegment
     */
    public function setTimeSegment($timeSegment)
    {
        $this->timeSegment = $timeSegment;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
}
