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
    try {
      //EXEMPLE  https://localhost:8000/api/post/agenda/new_intervention/1?date=2021-2-14&time=09:00&id_company=1&incident_ids[]=2&comment=coucou
      $response = [];
      $errors = [];

      $params = [
        'date',
        'time',
        'comment',
        'id_company',
        'incident_ids'
      ];

      foreach ($params as $param) {
        if (empty($request->query->get($param)) && $param != 'comment') {
          $errors[] = "{$param} is empty";
        }
        $routeParameters[$param] = $request->query->get($param);
      }

      if (!empty($errors)) {
        throw new \Exception(serialize($errors));
      }

      $date = \DateTime::createFromFormat('Y-m-j H:i', $routeParameters['date'] . " " . $routeParameters['time']);

      if (!$date) {
        throw new \Exception(serialize(["date not valid"]));
      }

      $company = $companyRepository->findOneBy(['id' => $routeParameters['id_company']]);

      if (!isset($company)) {
        throw new \Exception(serialize(["company don't exist"]));
      }

      if ($routeParameters['comment']) {
        $newIntervention = (new Intervention())->setComment($routeParameters['comment'])->setCompany($company)->setDatetime($date);
      } else {
        $newIntervention = (new Intervention())->setCompany($company)->setDatetime($date);
      }

      if (!isset($newIntervention)) {
        throw new \Exception(serialize(["intervention don't exist"]));
      }

      $em->persist($newIntervention);
      $em->flush();

      foreach ($routeParameters['incident_ids'] as $id) {
        $updateIncident = $incidentRepository->findOneBy(['id' => $id]);

        if (!isset($updateIncident)) {
          throw new \Exception(serialize(["incident_id° {$id} don't exist"]));
        }

        $updateIncident->setIntervention($newIntervention)->setStatus('assign');
        $em->persist($updateIncident);
        $em->flush();
      }

      //      $response = new Response($response);
      //      $response->headers->set('Content-Type', 'application/json');

      return new JsonResponse([
        "success" => true,
        "response" => $response
      ]);
    } catch (\Exception $exception) {
      return new JsonResponse([
        "success" => false,
        "response" => unserialize($exception->getMessage())
      ]);
    }
  }
}
