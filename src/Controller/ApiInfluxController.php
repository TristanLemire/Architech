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
  public function index(JsonMessage $jsonMessage): Response
  {
    $response = ApiInfluxData::getRequestInfluxData();

    if (!$response || empty($response)) {
      return $jsonMessage->getEmptyDataMessage();
    }

    return new JsonResponse($response);
  }
}
