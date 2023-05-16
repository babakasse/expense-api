<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController
{

    #[Route('/api/app_user', name: 'app_api_user', methods: ['GET'])]
    public function apiUser(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users', name: 'user_list', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        return $this->json($users);
    }

    #[Route('/api/user', name: 'user_create', methods: ['POST'])]
    public function createUser(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username'], $data['password'], $data['email'], $data['firstname'], $data['lastname'])) {
            return new Response('Missing required data', Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setDateOfBirth(new DateTime($data['dateOfBirth']));

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse('User created', Response::HTTP_CREATED);
    }

    #[Route('/api/user/{id}', name: 'user_show', methods: ['GET'])]
    public function showUser(UserRepository $userRepository, $id): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new Response('User not found', Response::HTTP_BAD_REQUEST);
        }

        return $this->json($user);
    }

}
