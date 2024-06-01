<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/applications', name: 'applications')]
class ApplicationsController extends AbstractController
{

    /**
     * @Route("/apply", name="new", methods={"POST"})
     */
    public function apply(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);



        return new Response('Apply confirmed', Response::HTTP_CREATED);
    }
}
