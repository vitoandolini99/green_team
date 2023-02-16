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
        $csvFilePath = $this->getParameter('kernel.project_dir') . '/public/csv/basnickevyrazy.csv';
        $data = array_map('str_getcsv', file($csvFilePath));
        array_shift($data);
        $questions = [];
        foreach ($data as $row) {
            if (count($row) >= 5) {
                $question = [
                    'text' => $row[0],
                    'correctAnswer' => $row[1],
                    'wrongAnswer1' => $row[2],
                    'wrongAnswer2' => $row[3],
                    'wrongAnswer3' => $row[4],
                ];
                $questions[] = $question;
            }
        }

        return $this->render('quiz.html.twig', [
            'questions' => $questions,
        ]);

    }
}