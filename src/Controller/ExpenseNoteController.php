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
use PHPUnit\Util\Json;

class ExpenseNoteController extends AbstractController
{
    #[Route('/api/app_expense_note', name: 'app_api_expense_note', methods: ['GET'])]
    public function apiExpenseNote(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to Expense Note controller!',
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
    ): JsonResponse {
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

        return new JsonResponse('Expense Note created', Response::HTTP_CREATED);
    }

    #[Route('/api/expense_note/{id}', name: 'expense_note_show', methods: ['GET'])]
    public function showExpenseNote(
        ExpenseNoteRepository $expenseNoteRepository,
        int $id
    ): JsonResponse {
        $expenseNote = $expenseNoteRepository->find($id);

        if (!$expenseNote) {
            return new JsonResponse('Expense Note not found', Response::HTTP_NOT_FOUND);
        }

        return $this->json($expenseNote);
    }

    #[Route('/api/expense_note/{id}', name: 'expense_note_update', methods: ['PUT'])]
    public function updateExpenseNote(
        Request $request,
        ManagerRegistry $doctrine,
        ExpenseNoteRepository $expenseNoteRepository,
        CompanyRepository $companyRepository,
        UserRepository $userRepository,
        int $id
    ): JsonResponse {
        $expenseNote = $expenseNoteRepository->find($id);

        if (!$expenseNote) {
            return new JsonResponse('Expense Note not found', JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['noteDate'], $data['noteType'], $data['amount'], $data['company'], $data['commercial'])) {
            return new JsonResponse('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        // Fetch the actual entities from the database
        $company = $companyRepository->find($data['company']);
        $commercial = $userRepository->find($data['commercial']);

        if (!$company) {
            return new JsonResponse('Company not found', Response::HTTP_BAD_REQUEST);
        }

        if (!$commercial) {
            return new JsonResponse('User not found', Response::HTTP_BAD_REQUEST);
        }


        $expenseNote->setNoteDate(DateTime::createFromFormat('Y-m-d', $data['noteDate']));
        $expenseNote->setNoteType($data['noteType']);
        $expenseNote->setAmount($data['amount']);
        $expenseNote->setCompany($company);
        $expenseNote->setCommercial($commercial);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($expenseNote);
        $entityManager->flush();

        return new JsonResponse('Expense Note updated', Response::HTTP_OK);
    }

    #[Route('/api/expense_note/{id}', name: 'expense_note_delete', methods: ['DELETE'])]
    public function deleteExpenseNote(
        ManagerRegistry $doctrine,
        ExpenseNoteRepository $expenseNoteRepository,
        int $id
    ): JsonResponse {
        $expenseNote = $expenseNoteRepository->find($id);

        if (!$expenseNote) {
            return new Response('Expense Note not found', Response::HTTP_NOT_FOUND);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($expenseNote);
        $entityManager->flush();

        return new JsonResponse('Expense Note deleted', Response::HTTP_OK);
    }
}
