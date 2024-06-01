<?php

namespace App\Controller;

use App\Entity\Student;
use App\Model\ApplicationDTO;
use App\Repository\StudentRepository;
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
        StudentRepository $studentRepository,
        InternshipOfferRepository $internshipOfferRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $data = $request->request->all();
        try {
            $applicationDTO = new ApplicationDTO($data);
            $internshipOffer =
            $student = $studentRepository->findOneBy(['email' => $applicationDTO->getEmail()]) ?? Student::fromApplicationDTO($applicationDTO);
//        const application = Application;
        } catch(\InvalidArgumentException|\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response('Apply confirmed', Response::HTTP_OK);
    }
}
