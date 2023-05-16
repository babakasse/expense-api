<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ExpenseNoteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ExpenseNote;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;

class ExpenseNoteController extends AbstractController
{
    #[Route('/api/app_expense_note', name: 'app_api_expense_note', methods: ['GET'])]
    public function apiExpenseNote(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ExpenseNoteController.php',
        ]);
    }

    #[Route('/api/expense_notes', name: 'expense_note_list', methods: ['GET'])]
    public function listExpenseNotes(ExpenseNoteRepository $expenseNoteRepository): JsonResponse
    {
        $expenseNotes = $expenseNoteRepository->findAll();

        return $this->json($expenseNotes);
    }

   
    #[Route('/api/expense_note', name: 'expense_note_create', methods: ['POST'])]
    public function createExpenseNote(
        Request $request,
        ManagerRegistry $doctrine,
        CompanyRepository $companyRepository,
        UserRepository $userRepository
    ): Response {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['noteDate'], $data['noteType'], $data['amount'], $data['company'], $data['commercial'])) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        // Fetch the actual entities from the database
        $company = $companyRepository->find($data['company']);
        $commercial = $userRepository->find(intval($data['commercial']));

        if (!$company) {
            return new Response('Company not found', Response::HTTP_BAD_REQUEST);
        }

        if (!$commercial) {
            return new Response('User not found', Response::HTTP_BAD_REQUEST);
        }

        $expenseNote = new ExpenseNote();
        $expenseNote->setNoteDate(DateTime::createFromFormat('Y-m-d', $data['noteDate']));
        $expenseNote->setNoteType($data['noteType']);
        $expenseNote->setAmount($data['amount']);
        $expenseNote->setCompany($company);
        $expenseNote->setCommercial($commercial);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($expenseNote);
        $entityManager->flush();

        return new Response('Expense Note created', Response::HTTP_CREATED);
    }
}
