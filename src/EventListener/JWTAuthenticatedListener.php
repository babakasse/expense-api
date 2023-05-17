<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class JWTAuthenticatedListener
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        // get user ID from payload
        $username = $payload['username'];

        // find user by Name
        $user = $this->userRepository->findOneBy(['username' => $username]);

        // check if user ID is not 1
        if (null === $user || 1 !== $user->getId()) {
            throw new AccessDeniedHttpException('Access denied');
        }
    }
}
