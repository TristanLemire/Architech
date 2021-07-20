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
  |> filter(fn: (r) => r["topic"] == "WEB3-GROUPE8/042101/116" or r["topic"] == "WEB3-GROUPE8/042102/112" or r["topic"] == "WEB3-GROUPE8/042102/114" or r["topic"] == "WEB3-GROUPE8/042102/116" or r["topic"] == "WEB3-GROUPE8/042103/114" or r["topic"] == "WEB3-GROUPE8/042103/112" or r["topic"] == "WEB3-GROUPE8/042103/116" or r["topic"] == "WEB3-GROUPE8/042104/112" or r["topic"] == "WEB3-GROUPE8/042104/114" or r["topic"] == "WEB3-GROUPE8/042104/116" or r["topic"] == "WEB3-GROUPE8/042105/112" or r["topic"] == "WEB3-GROUPE8/042105/114" or r["topic"] == "WEB3-GROUPE8/042105/116" or r["topic"] == "WEB3-GROUPE8/042106/112" or r["topic"] == "WEB3-GROUPE8/042106/114" or r["topic"] == "WEB3-GROUPE8/042106/116" or r["topic"] == "WEB3-GROUPE8/042107/112" or r["topic"] == "WEB3-GROUPE8/042107/116" or r["topic"] == "WEB3-GROUPE8/042107/114" or r["topic"] == "WEB3-GROUPE8/042108/112" or r["topic"] == "WEB3-GROUPE8/042108/114" or r["topic"] == "WEB3-GROUPE8/042108/116" or r["topic"] == "WEB3-GROUPE8/042109/112" or r["topic"] == "WEB3-GROUPE8/042109/114" or r["topic"] == "WEB3-GROUPE8/042109/116" or r["topic"] == "WEB3-GROUPE8/042110/112" or r["topic"] == "WEB3-GROUPE8/042110/114" or r["topic"] == "WEB3-GROUPE8/042202/112" or r["topic"] == "WEB3-GROUPE8/042110/116" or r["topic"] == "WEB3-GROUPE8/042202/114" or r["topic"] == "WEB3-GROUPE8/042202/116" or r["topic"] == "WEB3-GROUPE8/042204/112" or r["topic"] == "WEB3-GROUPE8/042204/114" or r["topic"] == "WEB3-GROUPE8/042204/116" or r["topic"] == "WEB3-GROUPE8/042205/112" or r["topic"] == "WEB3-GROUPE8/042205/114" or r["topic"] == "WEB3-GROUPE8/042205/116" or r["topic"] == "WEB3-GROUPE8/042206/112" or r["topic"] == "WEB3-GROUPE8/042206/114" or r["topic"] == "WEB3-GROUPE8/042206/116" or r["topic"] == "WEB3-GROUPE8/042207/112" or r["topic"] == "WEB3-GROUPE8/042101/112" or r["topic"] == "WEB3-GROUPE8/042101/114")';
        $tables = $client->createQueryApi()->queryStream($query, $org);

        foreach ($tables->each() as $record) {
            $response[] = $record;
        }

        return new JsonResponse($response);
    }
}
