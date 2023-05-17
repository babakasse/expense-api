<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;

class CompanyController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CompanyController.php',
        ]);
    }

    #[Route('/api/companies', name: 'company_list', methods: ['GET'])]
    public function listCompanies(CompanyRepository $companyRepository): JsonResponse
    {
        $companies = $companyRepository->findAll();

        return $this->json($companies);
    }

    #[Route('/api/company', name: 'company_create', methods: ['POST'])]
    public function createCompany(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'])) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        $company = new Company();
        $company->setName($data['name']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return new JsonResponse('Company created', Response::HTTP_CREATED);
    }

    #[Route('/api/company/{id}', name: 'company_show', methods: ['GET'])]
    public function showCompany(Company $company): JsonResponse
    {
        return $this->json($company);
    }

    #[Route('/api/company/{id}', name: 'company_update', methods: ['PUT'])]
    public function updateCompany(Request $request, Company $company, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'])) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        $company->setName($data['name']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return new JsonResponse('Company updated', Response::HTTP_OK);
    }
}
