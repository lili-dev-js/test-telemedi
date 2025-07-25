<?php

namespace App\Controller;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    #[Route('/api/departments', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name'])) {
            return new JsonResponse(['error' => 'Missing department name'], 400);
        }

        $department = new Department();
        $department->setName($data['name']);

        $em->persist($department);
        $em->flush();

        return new JsonResponse(['id' => $department->getId(), 'name' => $department->getName()], 201);
    }

    #[Route('/api/departments', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, min(100, (int)$request->query->get('limit', 20)));
        $offset = ($page - 1) * $limit;

        $repo = $em->getRepository(Department::class);
        $total = $repo->count([]);
        $departments = $repo->findBy([], ['name' => 'ASC'], $limit, $offset);

        $data = array_map(fn(Department $d) => [
            'id' => $d->getId(),
            'name' => $d->getName()
        ], $departments);

        return new JsonResponse([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $data
        ]);
    }

    #[Route('/api/departments/{id}', methods: ['GET'])]
    public function getOne(int $id, EntityManagerInterface $em): JsonResponse
    {
        $department = $em->getRepository(Department::class)->find($id);

        if (!$department) {
            return new JsonResponse(['error' => 'Department not found'], 404);
        }

        return new JsonResponse([
            'id' => $department->getId(),
            'name' => $department->getName()
        ]);
    }
}
