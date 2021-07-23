<?php

namespace App\Controller;

use App\Service\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiPostController extends AbstractController
{
  /**
   * @Route("/api/post/agenda/new_intervention/{id_building}", name="new_intervention")
   */
  public function index(int $id_building, Request $request, JsonMessage $jsonMessage): JsonResponse
  {
    $response = [];
    $errors = [];

    $params = [
      'date',
      'time',
      'comment',
      'type',
      'id_company',
      'interventions_id'
    ];

    foreach ($params as $param) {
      if (empty($request->query->get($param)) && $param != 'comment') {
        $errors[] = "{$param} is empty";
      }
      $routeParameters[$param] = $request->query->get($param);
    }

    if (isset($errors)) {
      return new JsonResponse($errors);
    }

    return new JsonResponse($response);
  }

}
