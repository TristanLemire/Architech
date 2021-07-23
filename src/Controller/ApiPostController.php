<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Entity\Intervention;
use App\Repository\CompanyRepository;
use App\Repository\IncidentRepository;
use App\Service\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ApiPostController extends AbstractController
{
  /**
   * @Route("/api/post/agenda/new_intervention/{id_building}", name="new_intervention")
   */
  public function index(int $id_building, Request $request, JsonMessage $jsonMessage, EntityManagerInterface $em, IncidentRepository $incidentRepository, CompanyRepository $companyRepository): JsonResponse
  {
    //     EXEMPLE  https://localhost:8000/api/post/agenda/new_intervention/1?date=2021-2-14&time=09:00&type="defective_air_conditioning"&id_company=1&interventions_id[]=2&comment=coucou
    $response = [];
    $errors = [];

    $params = [
      'date',
      'time',
      'comment',
      'id_company',
      'interventions_id'
    ];

    foreach ($params as $param) {
      if (empty($request->query->get($param)) && $param != 'comment') {
        $errors[] = "{$param} is empty";
      }
      $routeParameters[$param] = $request->query->get($param);
    }

    $date = \DateTime::createFromFormat('Y-m-j H:i', $routeParameters['date'] . " " . $routeParameters['time']);

    $company = $companyRepository->findOneBy(['id' => $routeParameters['id_company']]);

    if ($routeParameters['comment']) {
      $newIntervention = (new Intervention())->setComment($routeParameters['comment'])->setCompany($company)->setDatetime($date);
    } else {
      $newIntervention = (new Intervention())->setCompany($company)->setDatetime($date);
    }

    $em->persist($newIntervention);
    $em->flush();

    foreach ($routeParameters['interventions_id'] as $id) {
      $updateIncident = $incidentRepository->findOneBy(['id' => $id]);
      $updateIncident->setIntervention($newIntervention);

      $em->persist($updateIncident);
      $em->flush();
    }

    if (isset($errors)) {
      return new JsonResponse($errors);
    }

    $response = new Response($response);
    $response->headers->set('Content-Type', 'application/json');

    return $response;
  }
}
