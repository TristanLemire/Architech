<?php

namespace App\Controller;

use App\Repository\IncidentRepository;
use App\Repository\InterventionRepository;
use App\Service\JsonMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/dashboard/futureEvent/{id_building}", name="futureEvent")
     */
    public function futureEvent(int $id_building, InterventionRepository $interventionRepository, JsonMessage $jsonMessage): JsonResponse
    {
        $response = array();
        $results = $interventionRepository->futurEvent($id_building);

        if (!$results) {
            return $jsonMessage->getEmptyDataMessage();
        }

        foreach ($results as $result) {
            $response[] = array(
                'incident_id' => $result["id"],
                'incident_type' => $result["type"],
                'incident_status' => $result["status"],
                'intervention_datetime' => $result["datetime"],
                'intervention_company' => $result["company"],
                'classroom_name' => $result["name"],
                'classroom_floor' => $result["floor"],
                'classroom_zone' => $result["zone"],
            );
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/dashboard/annualEvolution/{id_building}", name="annualEvolution")
     */
    public function annualEvolution(int $id_building, IncidentRepository $incidentRepository, JsonMessage $jsonMessage): JsonResponse
    {
        $response = array();
        $results = $incidentRepository->annualEvolution($id_building);

        if (!$results) {
            return $jsonMessage->getEmptyDataMessage();
        }

        foreach ($results as $result) {
            $response[] = array(
                'incident_id' => $result->getId(),
                'incident_title' => $result->getTitle(),
                'incident_date' => $result->getDate(),
                'incident_type' => $result->getType(),
                'incident_status' => $result->getStatus(),
            );
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/dashboard/statsincidents/{id_building}", name="statsincidents")
     */
    public function getStatsIncidents(int $id_building, IncidentRepository $incidentRepository, JsonMessage $jsonMessage): JsonResponse
    {
        $response = array();
        $results = $incidentRepository->findIncidentByIdBuilding($id_building);

        if (!$results) {
            return $jsonMessage->getEmptyDataMessage();
        }

        dump($results);

        foreach ($results as $result) {
        }
        return new JsonResponse($response);
    }
}
