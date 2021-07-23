<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use App\Repository\IncidentRepository;
use App\Repository\BuildingRepository;
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

            //TODO: gerer le cas id_tervention = null
            $incidents[$result['id_intervention']][] = [
                'incident_id' => $result["id"],
                'incident_type' => $result["type"],
                'incident_status' => $result["status"],
                'classroom_name' => $result["name"],
                'classroom_floor' => $result["floor"],
                'classroom_zone' => $result["zone"],
            ];

            $response[$result['id_intervention']] = [
                'intervention_datetime' => $result["datetime"]->format("Y-m-d H:i:s"),
                'intervention_company' => $result["company"],
                'intervention_type' => $result["type"],
                'intervention_comment' => $result["comment"],
                'incidents' => $incidents[$result['id_intervention']],
            ];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/dashboard/allFutureEvent/{id_building}", name="allFutureEvent")
     */
    public function allFutureEvent(int $id_building, InterventionRepository $interventionRepository, JsonMessage $jsonMessage): JsonResponse
    {
        $response = array();
        $results = $interventionRepository->allFuturEvent($id_building);

        if (!$results) {
            return $jsonMessage->getEmptyDataMessage();
        }

        $interventions = [];
        foreach ($results as $result) {

            $incidents[$result['id_intervention']][] = [
                'incident_id' => $result["id"],
                'incident_type' => $result["type"],
                'incident_status' => $result["status"],
                'classroom_name' => $result["name"],
                'classroom_floor' => $result["floor"],
                'classroom_zone' => $result["zone"],
            ];

            $interventions[$result['id_intervention']] = [
                'intervention_id' => $result["id_intervention"],
                'intervention_datetime' => $result["datetime"],
                'intervention_company' => $result["company"],
                'intervention_type' => $result["type"],
                'intervention_comment' => $result["comment"],
                'incidents' => $incidents[$result['id_intervention']],
            ];
        }

        foreach ($interventions as $intervention) {

            if (array_key_exists($intervention["intervention_datetime"]->format('m') . "-" . $intervention["intervention_datetime"]->format('Y'), $response)) {
                array_push($response[$intervention["intervention_datetime"]->format('m') . "-" . $intervention["intervention_datetime"]->format('Y')], $intervention);
            } else {
                $response[$intervention["intervention_datetime"]->format('m') . "-" . $intervention["intervention_datetime"]->format('Y')] = [$intervention];
            }
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
        $response = [];
        $results_current_month = $incidentRepository->findIncidentByIdBuilding($id_building, true);
        $results_prev_month = $incidentRepository->findIncidentByIdBuilding($id_building);

        if (!$results_current_month && !$results_prev_month) {
            return $jsonMessage->getEmptyDataMessage();
        }

        $response['info'] = [
            'total_incidents_current_month' => count($results_current_month),
            'total_incidents_prev_month' => count($results_prev_month)
        ];

        $results = array_merge($results_current_month, $results_prev_month);

        foreach ($results as $result) {
            $response['incidents'][$result["type"]][] = [
                'incident_id' => $result["id"],
                'incident_title' => $result["title"],
                'incident_date' => $result["date"]->format('Y-m-d H:i:s'),
                'incident_type' => $result["type"],
                'incident_status' => $result["status"],
                'classroom_name' => $result["name"],
                'classroom_floor' => $result["floor"],
                'classroom_zone' => $result["zone"]
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/dashboard/infobuilding/{id_building}", name="info_building")
     */
    public function getInfoBuilding(int $id_building, BuildingRepository $buildingRepository, JsonMessage $jsonMessage): JsonResponse
    {
        $response = [];
        $results = $buildingRepository->findInfoByIdBuilding($id_building);

        if (!$results) {
            return $jsonMessage->getEmptyDataMessage();
        }

        foreach ($results as $result) {
            $response = [
                'manager' => [
                    'last_name' => $result['last_name'],
                    'first_name' => $result['first_name'],
                    'phone_manager' => $result['phone_manager'],
                    'gender' => $result['gender'],
                    'manager_mail' => $result['mail'],
                ],
                'building' => [
                    'name_building' => $result['name_building'],
                    'phone_building' => $result['phone_building'],
                    'address' => $result['address'],
                    'zipcode' => $result['zipcode'],
                    'mail' => $result['mail'],
                    'city' => $result['city']
                ],
                'stats' => [
                    'number_rooms' => (int)$result['number_rooms'] ?? 0,
                    'number_sensors' => (int)$result['number_sensor'] ?? 0,
                ]
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/agenda/{id_building}", name="agenda")
     */
    public function agenda(int $id_building, IncidentRepository $incidentRepository, CompanyRepository $company, JsonMessage $jsonMessage): JsonResponse
    {
        $resultsAgenda = $incidentRepository->agenda($id_building);

        if (!$resultsAgenda) {
            return $jsonMessage->getEmptyDataMessage();
        }

        $resultsCompany = $company->getCompany($id_building);

        if (!$resultsCompany) {
            return $jsonMessage->getEmptyDataMessage();
        }

        foreach ($resultsCompany as $resultCompany) {
            $incidents = [];
            foreach ($resultsAgenda as $resultAgenda) {
                if ($resultCompany->getType() == $resultAgenda["type"]) {
                    $incidents[] = [
                        'incident_id' => $resultAgenda["id"],
                        'incident_title' => $resultAgenda["title"],
                        'incident_date' => $resultAgenda["date"]->format('Y-m-d H:i:s'),
                        'incident_type' => $resultAgenda["type"],
                        'incident_status' => $resultAgenda["status"],
                        'classroom_id' => $resultAgenda["classroom_id"],
                        'classroom_name' => $resultAgenda["name"],
                        'classroom_floor' => $resultAgenda["floor"],
                        'classroom_zone' => $resultAgenda["zone"],
                    ];
                }
            }
            $response[$resultCompany->getType()] = [
                'incidents' => $incidents,
                'company' => [
                    'id' => $resultCompany->getId(),
                    'name' => $resultCompany->getName(),
                    'phone' => $resultCompany->getPhone(),
                    'mail' => $resultCompany->getMail(),
                    'type' => $resultCompany->getType(),
                ],
            ];
        }

        return new JsonResponse($response);
    }
}
