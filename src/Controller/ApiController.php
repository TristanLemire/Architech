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

            dump($results);

        foreach ($results as $result) {
            $response[] = array(
                'id' => $result->getId(),
            );
        }
        return new JsonResponse($response);
    }
}
