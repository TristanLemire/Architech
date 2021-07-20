<?php

namespace App\Controller;

use App\Service\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

const SENSOR_TYPE = [
  'Temperature' => 112,
  'Humidité' => 114,
  'Pression' => 116
];

class ApiInfluxController extends AbstractController
{
  /**
   * @Route("/api/influx", name="api_influx")
   */
  public function index(JsonMessage $jsonMessage): Response
  {
    $response = array();
    # You can generate a Token from the "Tokens Tab" in the UI
    $token = 'ibJqsWzlGD-lgMSSTuYOcG2iGybuD6sz8Famee00YhzQvEagUO_ULKjb94SrL-XzbLCbLsNAk_JZTgqscY_OUA==';
    $org = 'tristan.lemire@hetic.net';
    $bucket = "tristan.lemire's Bucket";

    $client = new Client([
      "url" => "https://eu-central-1-1.aws.cloud2.influxdata.com",
      "token" => $token,
      "bucket" => $bucket,
      'org' => $org
    ]);

    $query = 'from(bucket: "'.$bucket.'")
  |> range(start: -5m)
  |> filter(fn: (r) => r["_measurement"] == "Humidité" or r["_measurement"] == "Pression" or r["_measurement"] == "Temperature")
  |> filter(fn: (r) => r["NodeID"] == "042101" or r["NodeID"] == "042102" or r["NodeID"] == "042103" or r["NodeID"] == "042104" or r["NodeID"] == "042105" or r["NodeID"] == "042106" or r["NodeID"] == "042107" or r["NodeID"] == "042108" or r["NodeID"] == "042109" or r["NodeID"] == "042110" or r["NodeID"] == "042202" or r["NodeID"] == "042203" or r["NodeID"] == "042204" or r["NodeID"] == "042205" or r["NodeID"] == "042206" or r["NodeID"] == "042207" or r["NodeID"] == "042208" or r["NodeID"] == "042209" or r["NodeID"] == "042210" or r["NodeID"] == "042301" or r["NodeID"] == "042302" or r["NodeID"] == "042303" or r["NodeID"] == "042304")
  |> filter(fn: (r) => r["_field"] == "data_value")
    |> last()';
    $tables = $client->createQueryApi()->queryStream($query, $org);

    foreach ($tables->each() as $record) {
      $record_item = $record->values;
      $measurement = $record_item["_measurement"];

      $response[$record_item['NodeID']][] = [
        "id" => $record_item['table'],
        "sensor_id" => SENSOR_TYPE[$measurement],
        "type" => $measurement,
        "node_id" => $record_item['NodeID'],
        "value" => $record_item['_value'],
      ];
    }

    return new JsonResponse($response);
  }
}
