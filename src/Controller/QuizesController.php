<?php
// src/Controller/QuizesController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizesController extends AbstractController{

    #[Route('/prvak', name: 'quizy-prvak')]
    public function quizes(): Response {
        return $this->render('themes/prvak.html.twig');
    }    
}