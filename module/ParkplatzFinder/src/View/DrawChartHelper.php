<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 30.09.16
 * Time: 06:51
 */

namespace ParkplatzFinder\View;


use Zend\View\Helper\AbstractHelper;

class DrawChartHelper extends AbstractHelper
{
    private static $numberChart = 0;

    private $numberTimeSegments;

    /**
     * DrawChartHelper constructor.
     */
    public function __construct($numberTimeSegments)
    {
        $this->numberTimeSegments = $numberTimeSegments;
    }


    public function __invoke($occupancyPrediction)
    {
        self::$numberChart++;
        $this->renderJs($occupancyPrediction);
        return $this->renderCanvasElement();
    }

    private function renderCanvasElement()
    {
        return "<br/><h5>Prognose freier Parkplätze:</h5><canvas class = 'chart' id ='chartNr" . self::$numberChart . "'></canvas>";
    }

    public function prepareData($occupancyPrediction)
    {
        $preparedData = [];

        foreach ($occupancyPrediction as $dayIndex => $dayPrediction) {
            for ($i = 0; $i < $this->numberTimeSegments; $i++) {
                $preparedData[$dayIndex][] = (isset($dayPrediction[$i]) ? $dayPrediction[$i] : 0);
            }
        }
        return $preparedData;
    }

    public function getLabels()
    {
        $minutesPerSegment = 60 * 24 / $this->numberTimeSegments;
        $labels = [];
        for ($i = 0; $i < $this->numberTimeSegments; $i++) {
            $labels[] = date("H:i", $i * $minutesPerSegment * 60);
        }
        return $labels;
    }

    private function renderJs($occupancyPrediction)
    {
        $chartId = "chartNr" . self::$numberChart;
        $preparedData = $this->prepareData($occupancyPrediction);
        $labels = '"' . implode('", "', $this->getLabels()) . '"';
        $dataSo = implode(",", $preparedData[0]);
        $dataMo = implode(",", $preparedData[1]);
        $dataDi = implode(",", $preparedData[2]);
        $dataMi = implode(",", $preparedData[3]);
        $dataDo = implode(",", $preparedData[4]);
        $dataFr = implode(",", $preparedData[5]);
        $dataSa = implode(",", $preparedData[6]);

        $this->getView()->inlineScript()->captureStart();
        echo <<<JS
        $(document).ready(function(){
            var myChart = new Chart($("#$chartId"),{
                type: 'line',
                data: {
                    xLabels: [$labels],
                    yLabels: ["0", "< 10","10 - 30", "30 - 50", "> 50" ],
                    datasets: [{
                        label: 'Montag',
                        data: [$dataMo],
                        borderWidth: 3,
                        borderColor: "rgba(75,192,192,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Dienstag',
                        data: [$dataDi],
                        borderWidth: 3,
                        borderColor: "rgba(75,75,192,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Mittwoch',
                        data: [$dataMi],
                        borderWidth: 3,
                        borderColor: "rgba(192,75,192,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Donnerstag',
                        data: [$dataDo],
                        borderWidth: 3,
                        borderColor: "rgba(192,75,75,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Freitag',
                        data: [$dataFr],
                        borderWidth: 3,
                        borderColor: "rgba(192,192,75,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Samstag',
                        data: [$dataSa],
                        borderWidth: 3,
                        borderColor: "rgba(75,192,75,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    },
                    {
                        label: 'Sonntag',
                        data: [$dataSo],
                        borderWidth: 3,
                        borderColor: "rgba(192,192,192,1)",
                        steppedLine: false,
                        fill: false,
                        cubicInterpolationMode: "monotone",
                        lineTension: 0,
                        pointRadius: 5,
                    }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                // Create scientific notation labels
                                callback: function(value, index, values) {
                                   switch(value)
                                   {
                                       case 0:
                                       {
                                           return "keine Daten";
                                       }
                                       case 1:
                                       {
                                           return "< 10";
                                       }
                                       case 2:
                                       {
                                           return "10 -30";
                                       }
                                       case 3:
                                       {
                                           return "30 - 50";
                                       }
                                       case 4: 
                                       {
                                           return "> 50";
                                       }
                                   }
                                },
                                min: 0,
                                max: 4
                            }
                        }]
                    }
    }
            });
        });
JS;

        $this->getView()->inlineScript()->captureEnd();
    }
}