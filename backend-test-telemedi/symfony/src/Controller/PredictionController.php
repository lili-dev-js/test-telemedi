<?php

namespace App\Controller;

use App\Entity\Prediction;
use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PredictionController extends AbstractController
{
    #[Route('/api/predictions', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (
            !$data ||
            !isset($data['date'], $data['department'])
        ) {
            return new JsonResponse(['error' => 'Invalid data: missing date or department'], 400);
        }

        // Pobierz ID department z URL lub int
        $departmentId = null;
        if (is_string($data['department']) && preg_match('#/api/departments/(\d+)#', $data['department'], $matches)) {
            $departmentId = (int)$matches[1];
        } elseif (is_int($data['department'])) {
            $departmentId = $data['department'];
        } else {
            return new JsonResponse(['error' => 'Invalid department format'], 400);
        }

        $department = $em->getRepository(Department::class)->find($departmentId);
        if (!$department) {
            return new JsonResponse(['error' => 'Department not found'], 404);
        }

        // Sprawdź, czy mamy dokładnie 24 pola h00..h23
        $hours = [];
        for ($i = 0; $i < 24; $i++) {
            $hourKey = 'h' . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            if (!array_key_exists($hourKey, $data)) {
                return new JsonResponse(['error' => "Missing hourly data for $hourKey"], 400);
            }
            $hours[$hourKey] = (float)$data[$hourKey];
        }

        // Stwórz i ustaw prediction
        $prediction = new Prediction();
        try {
            $prediction->setDate(new \DateTime($data['date']));
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], 400);
        }
        $prediction->setDepartment($department);

        foreach ($hours as $hourKey => $value) {
            $setter = 'set' . strtoupper($hourKey);
            if (method_exists($prediction, $setter)) {
                $prediction->$setter($value);
            } else {
                return new JsonResponse(['error' => "Setter $setter not found"], 500);
            }
        }

        $em->persist($prediction);
        $em->flush();

        return new JsonResponse(['status' => 'Prediction created', 'id' => $prediction->getId()], 201);
    }

    #[Route('/api/predictions/{id}', methods: ['GET'])]
    public function getOne(int $id, EntityManagerInterface $em): JsonResponse
    {
        $prediction = $em->getRepository(Prediction::class)->find($id);

        if (!$prediction) {
            return new JsonResponse(['error' => 'Prediction not found'], 404);
        }

        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourKey = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $getter = 'getH' . $hourKey;
            $hourlyData[$hourKey . ':00'] = $prediction->$getter();
        }

        return new JsonResponse([
            'id' => $prediction->getId(),
            'date' => $prediction->getDate()->format('Y-m-d'),
            'department' => $prediction->getDepartment()->getName(),
            'hourlyData' => $hourlyData,
        ]);
    }

    #[Route('/api/predictions', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, min(100, (int)$request->query->get('limit', 20)));
        $offset = ($page - 1) * $limit;

        $repo = $em->getRepository(Prediction::class);
        $total = $repo->count([]);
        $predictions = $repo->findBy([], ['date' => 'DESC'], $limit, $offset);

        $results = [];

        foreach ($predictions as $prediction) {
            $hourlyData = [];
            for ($i = 0; $i < 24; $i++) {
                $hourKey = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                $getter = 'getH' . $hourKey;
                $hourlyData[$hourKey . ':00'] = $prediction->$getter();
            }

            $results[] = [
                'id' => $prediction->getId(),
                'date' => $prediction->getDate()->format('Y-m-d'),
                'department' => $prediction->getDepartment()->getName(),
                'hourlyData' => $hourlyData,
            ];
        }

        return new JsonResponse([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $results,
        ]);
    }
}
