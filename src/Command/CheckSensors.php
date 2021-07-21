<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ApiInfluxData;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;


class CheckSensors extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:checkSensors';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sensor_type = [
            112 => 'heat_leak',
            114 => 'high_humidity',
            116 => 'defective_air_conditioning'
        ];

        $conn = $this->container->get('doctrine')->getConnection();

        $sqlQueries = "SELECT i.*, c.name as classroom_number
                FROM incident i 
                INNER JOIN classroom c ON i.classroom_id = c.id 
                INNER JOIN building b ON c.building_id = b.id  
                WHERE status = \"assign\" OR status = \"in_progress\"";

        $stmt = $conn->prepare($sqlQueries);
        $stmt->execute();
        $incidents = $stmt->fetchAll();
        $apiInfluxData = new ApiInfluxData();
        $response_influx_data = $apiInfluxData->getRequestInfluxData();

        function findIncident($classroom_number,$type,$incidents) {
            $haveIncident = false;
            foreach ($incidents as $incident){
                if($incident["classroom_number"] === $classroom_number && $incident["type"] === $type){
                    $haveIncident= true;
                }
            }
            return $haveIncident;
        }

        function pushNewInciddent($sensor,$sensor_type,$incidents,$conn) {
            if(!findIncident(substr($sensor["node_id"], -3),$sensor_type[$sensor["sensor_id"]],$incidents)){
                $sqlQueries = "select id, zone from classroom where name =" . substr($sensor["node_id"], -3);

                $stmt = $conn->prepare($sqlQueries);
                $stmt->execute();

                $classroom = $stmt->fetchAll();
                $title = "incident salle ".$classroom[0]["zone"].substr($sensor["node_id"], -3);
                $date = new \DateTime('now');
                $dateString = $date->format("Y-m-d H:i:s");
                $type = $sensor_type[$sensor["sensor_id"]];

                $sqlQueries = "INSERT INTO incident (classroom_id, title, date, type, status) VALUES (".$classroom[0]["id"].",'".$title."','".$dateString."','".$type."','assign');";
                $stmt = $conn->prepare($sqlQueries);
                $stmt->execute();
            }
        }

        foreach ($response_influx_data as $node) {
            foreach ($node as $sensor) {
                // la température dans les locaux à usage d'enseignement ne peut être supérieure à 19°,
                // mais elle doit obligatoirement être supérieure à 16°.
                if ($sensor["sensor_id"] === 112 && ($sensor["value"] > 19 || $sensor["value"] < 16)) {
                    echo "Probleme de temperature" . " " . substr($sensor["node_id"], -3) . "\n";
                    pushNewInciddent($sensor,$sensor_type,$incidents,$conn);
                }

                // la zone optimale de confort se situe entre 30 et 70 % pour l’humidité
                if ($sensor["sensor_id"] === 114 && ($sensor["value"] > 70 || $sensor["value"] < 30)) {
                    if(!findIncident(substr($sensor["node_id"], -3),$sensor_type[$sensor["sensor_id"]],$incidents)){
                        echo "Probleme d'humidité" . " " . substr($sensor["node_id"], -3) . "\n";
                        pushNewInciddent($sensor,$sensor_type,$incidents,$conn);
                    }
                }

                if ($sensor["sensor_id"] === 116 && ($sensor["value"] > 1040 || $sensor["value"] < 1010)) {
                    if(!findIncident(substr($sensor["node_id"], -3),$sensor_type[$sensor["sensor_id"]],$incidents)){
                        echo "Probleme de pression sur la salle " . " " . substr($sensor["node_id"], -3) . "\n";
                        pushNewInciddent($sensor,$sensor_type,$incidents,$conn);
                    }
                }
            }
        }
    }}