<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 29.09.16
 * Time: 20:23
 */

namespace ParkplatzFinder\Form;


use Ainias\Core\Form\MyForm;
use Zend\Form\Element\Select;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

class SelectTrainStationForm extends MyForm
{
    /** @var  Select */
    private $trainStation;
    public function __construct($parkingLotsValueOptions = [], FlashMessenger $flashMessenger = null, $name = null, array $options = [])
    {
        parent::__construct($flashMessenger, $name, $options);
        $this->setTrainStations($parkingLotsValueOptions);
    }

    protected function addElements()
    {
        $trainStation = new Select("trainStation");
        $trainStation->setLabel("Bahnhof");
        $this->add($trainStation);
        $this->trainStation = $trainStation;
    }

    protected function setTrainStations(array $trainStationNames)
    {
        $this->trainStation->setValueOptions($trainStationNames);
    }
}