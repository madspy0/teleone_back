<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;


class ApiController extends AbstractController
{
    #[Route('/api/users', name: 'api_users', methods: 'GET')]
    public function users(ManagerRegistry $doctrine): Response
    {
/*        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }*/
        try {
            return $this->json([
                'users' => $doctrine->getRepository(User::class)->findAll(),
            ]);
        } catch (\Exception $e) {
            return $this->json(['status'=>false, 'message' => $e->getMessage()], $e->getCode());
        }
    }
}
