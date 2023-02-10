<?php
// src/Controller/MainController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController{
    
    #[Route('/quiz', name: 'quizexample')]
    public function quizexample(): Response {
        return $this->render('quiz.html.twig');
    }
}