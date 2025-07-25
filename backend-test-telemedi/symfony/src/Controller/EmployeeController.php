<?php
namespace App\Controller;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    #[Route('/api/employee', name: 'employee_post', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['name'], $data['surname'], $data['department'], $data['performance'])) {
            return new JsonResponse(['error' => 'Invalid or missing data'], 400);
        }

        $employee = new Employee();
        $employee->setName($data['name']);
        $employee->setSurname($data['surname']);
        $employee->setDepartment($data['department']);
        $employee->setPerformance($data['performance']);

        $em->persist($employee);
        $em->flush();

        return new JsonResponse(['status' => 'Employee created'], 201);
    }

    #[Route('/api/employee/{id}', name: 'employee_get', methods: ['GET'])]
    public function read(int $id, EntityManagerInterface $em): JsonResponse
    {
        $employee = $em->getRepository(Employee::class)->find($id);

        if (!$employee) {
            return new JsonResponse(['error' => 'Employee not found'], 404);
        }

        return new JsonResponse([
            'id' => $employee->getId(),
            'name' => $employee->getName(),
            'surname' => $employee->getSurname(),
            'department' => $employee->getDepartment(),
            'performance' => $employee->getPerformance(),
        ]);
    }

    #[Route('/api/employees', name: 'employee_list', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, min(100, (int)$request->query->get('limit', 10)));

        $repository = $em->getRepository(Employee::class);

        $query = $repository->createQueryBuilder('e')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $employees = $query->getResult();

        $data = [];
        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->getId(),
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'department' => $employee->getDepartment(),
                'performance' => $employee->getPerformance(),
            ];
        }

        $total = (int)$repository->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $data,
        ]);
    }
}
