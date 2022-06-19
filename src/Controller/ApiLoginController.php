<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Service\CreateJwt;

class ApiLoginController extends AbstractController
{
/*    private CreateJwt $createJwt;
    public function __construct(CreateJwt $createJwt)
    {
        $this->createJwt=$createJwt;
    }*/
    #[Route('/api/login', name: 'api_login', methods: 'POST')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $this->json([
            'username' => $user->getUserIdentifier(),
          //  'token' => $this->createJwt->newToken($user->getUserIdentifier())
        ]);
    }
}
