<?php

namespace App\Controller;

use App\Model\ApplicationDTO;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Application;

#[Route('/api/applications', name: 'applications_')]
class ApplicationsController extends AbstractController
{
    #[Route(path: '/apply', name: 'new', methods: ['POST'])]
    public function apply(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $data = $request->request->all();
        try {
            $applicationDTO = new ApplicationDTO($data);
            $user = $userRepository->findOneBy(['email' => $applicationDTO->getEmail()]);
//        const application = Application;
        } catch(\InvalidArgumentException|\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response('Apply confirmed', Response::HTTP_OK);
    }
}
