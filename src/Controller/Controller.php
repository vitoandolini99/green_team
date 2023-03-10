<?php
// src/Controller/Controller.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController{

    #[Route('/', name: 'homepage')]
    public function home(): Response {
        return $this->render('index.html.twig');
    }    
}