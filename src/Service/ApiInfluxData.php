<?php


namespace App\Service;

use InfluxDB2\Client;

const SENSOR_TYPE = [
  'Temperature' => 112,
  'Humidité' => 114,
  'Pression' => 116
];

const BUCKET_NAME = "tristan.lemire's Bucket";
const TOKEN = 'ibJqsWzlGD-lgMSSTuYOcG2iGybuD6sz8Famee00YhzQvEagUO_ULKjb94SrL-XzbLCbLsNAk_JZTgqscY_OUA==';
const ORG = 'tristan.lemire@hetic.net';

class ApiInfluxData
{
  public $client;

  public function __construct()
  {
    $this->client = new Client([
      "url" => "https://eu-central-1-1.aws.cloud2.influxdata.com",
      "token" => TOKEN,
      "bucket" => BUCKET_NAME,
      'org' => ORG
    ]);
  }

  public function getRequestInfluxData()
  {
    $response = array();

    $query = 'from(bucket: "' . BUCKET_NAME . '")
      |> range(start: -5m)
      |> filter(fn: (r) => r["_measurement"] == "Humidité" or r["_measurement"] == "Pression" or r["_measurement"] == "Temperature")
      |> filter(fn: (r) => r["NodeID"] == "042101" or r["NodeID"] == "042102" or r["NodeID"] == "042103" or r["NodeID"] == "042104" or r["NodeID"] == "042105" or r["NodeID"] == "042106" or r["NodeID"] == "042107" or r["NodeID"] == "042108" or r["NodeID"] == "042109" or r["NodeID"] == "042110" or r["NodeID"] == "042202" or r["NodeID"] == "042203" or r["NodeID"] == "042204" or r["NodeID"] == "042205" or r["NodeID"] == "042206" or r["NodeID"] == "042207" or r["NodeID"] == "042208" or r["NodeID"] == "042209" or r["NodeID"] == "042210" or r["NodeID"] == "042301" or r["NodeID"] == "042302" or r["NodeID"] == "042303" or r["NodeID"] == "042304" or r["NodeID"] == "042211")
      |> filter(fn: (r) => r["_field"] == "data_value")
      |> last()';

    $tables = $this->client->createQueryApi()->queryStream($query, ORG);

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

    return $response;
  }

  public function getSensorGraph(string $node_id, string $type_sensor)
  {
    $response = [];

    $query = 'from(bucket: "' . BUCKET_NAME . '")
      |> range(start: -24h)
      |> filter(fn: (r) => r["_measurement"] == "' . $type_sensor . '")
      |> filter(fn: (r) => r["NodeID"] == "' . $node_id . '")
      |> filter(fn: (r) => r["_field"] == "data_value")
      |> yield(name: "mean")';

    $tables = $this->client->createQueryApi()->queryStream($query, ORG);

    if (!isset($tables)) {
      return $response;
    }

    foreach ($tables->each() as $record) {
      $record_item = $record->values;

      $measurement = $record_item["_measurement"];
      $date = new \DateTime($record_item['_time']);

      $response[$record_item['NodeID']][] = [
        "date" => $date->format("Y-m-d H:i:s"),
        "sensor_id" => SENSOR_TYPE[$measurement],
        "type" => $measurement,
        "node_id" => $record_item['NodeID'],
        "value" => $record_item['_value'],
      ];
    }

    return $response;
  }
}
