<?php
// src/Controller/ProhlaseniController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LicenseController extends AbstractController{

    #[Route('/license', name: 'license')]
    public function license(): Response {
        return $this->render('license.html.twig');
    }    
}