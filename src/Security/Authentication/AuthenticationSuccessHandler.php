<?php

namespace App\Security\Authentication;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use App\Service\CreateJwt;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private CreateJwt $createJwt;
    public function __construct(CreateJwt $createJwt)
    {
        $this->createJwt=$createJwt;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $user = $token->getUser();

        return new JsonResponse(['username' => $user->getUserIdentifier(), 'token' => $this->createJwt->newToken($user->getUserIdentifier())]);
    }
}
