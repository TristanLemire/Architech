<?php

namespace App\Controller;

use App\Repository\IncidentRepository;
use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/{id}", name="api2")
     */
    public function statIncident(int $id, IncidentRepository $incidentRepository): JsonResponse
    {
        $response = array();
        $results = $incidentRepository->findOneIncident($id);

        foreach ($results as $result) {
            $response[] = array(
                'id' => $result->getId(),
                'classroom_id' => $result->getClassroom()->getId(),
                'date' => $result->getDate(),
                'type' => $result->getType(),
                'status' => $result->getStatus(),
            );
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/dashboard/futureEvent/{id_building}", name="futureEvent")
     */
    public function futureEvent(int $id_building, InterventionRepository $interventionRepository): JsonResponse
    {
        $response = array();
            $results = $interventionRepository->futurEvent($id_building);

        //'a.id, a.type, i.datetime, i.company, c.name, c.floor, c.zone, a.status')

        foreach ($results as $result) {
            $response[] = array(
                'incident_id' => $result["id"],
                'incident_type' => $result["type"],
                'incident_status' => $result["status"],
                'intervention_datetime' => $result["datetime"],
                'intervention_datetime_company' => $result["company"],
                'classroom_name' => $result["name"],
                'classroom_floor' => $result["floor"],
                'classroom_zone' => $result["zone"],
            );
        }
        return new JsonResponse($response);
    }

  /**
   * @Route("/api/dashboard/statsincidents/{id_building}", name="futureEvent")
   */
  public function getStatsIncidents(int $id_building, IncidentRepository $incidentRepository): JsonResponse
  {
    $response = array();
    $results = $incidentRepository->findIncidentByIdBuilding($id_building);

    dump($results);

    foreach ($results as $result) {

    }
    return new JsonResponse($response);
  }
}
