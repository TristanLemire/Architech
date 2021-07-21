<?php

namespace App\Controller;

use App\Service\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiInfluxData;

class ApiInfluxController extends AbstractController
{
  /**
   * @Route("/api/influx", name="api_influx")
   */
  public function index(JsonMessage $jsonMessage, ApiInfluxData $apiInfluxData): Response
  {
    $response = $apiInfluxData->getRequestInfluxData();

    if (!$response || empty($response)) {
      return $jsonMessage->getEmptyDataMessage();
    }

    return new JsonResponse($response);
  }

  /**
   * @Route("/api/influx/graphSensor/{node_id}/{sensor_type}", name="api_influx_sensor_graph_data")
   */
  public function graphSensor(string $node_id,string $sensor_type, JsonMessage $jsonMessage,ApiInfluxData $apiInfluxData): Response
  {
    $response = $apiInfluxData->getSensorGraph((string)$node_id, $sensor_type);

    if (!$response || empty($response)) {
      return $jsonMessage->getEmptyDataMessage();
    }

    return new JsonResponse($response);
  }

}
