<?php
// src/Controller/ProhlaseniController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProhlaseniController extends AbstractController{

    #[Route('/o-nas', name: 'prohlaseni-o-pristupnosti')]
    public function prohlaseni(): Response {
        return $this->render('about.html.twig');
    }    
}