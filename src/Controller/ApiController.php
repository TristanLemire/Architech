<?php

namespace App\Controller;

use App\Repository\IncidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
                'classroom_id' => $result->getClassroom(),
                'date' => $result->getDate(),
                'type' => $result->getType(),
                'status' => $result->getStatus(),
            );
        }
        return new JsonResponse($response);
    }
}
