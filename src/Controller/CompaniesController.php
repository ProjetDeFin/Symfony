<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\Student;
use App\Model\ApplicationDTO;
use App\Repository\CompanyRepository;
use App\Repository\InternshipOfferRepository;
use App\Repository\ResetPasswordRepository;
use App\Repository\StudentRepository;
use App\Service\ApiResponseService;
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Application;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[Route('/api/companies', name: 'applications_')]
class CompaniesController extends AbstractController
{
    public function __construct(
    ) {
    }
}
