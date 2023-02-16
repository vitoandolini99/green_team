<?php
// src/Controller/MainController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;

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

    #[Route('/certificate', name: 'certificate')]
    public function certificateGenerator(): Response {
        $name = 'John Doe';
        $percentage = 85;

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('Certificate Generator');
        $pdf->SetAuthor('John Doe');
        $pdf->SetTitle('Certificate of Completion');
        $pdf->SetSubject('Certificate');

        $pdf->SetMargins(0, 30, 0);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $img_file = 'public/images/certificate_background.jpeg';
        $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);


        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(0, 15, 'Certificate of Completion', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 16);

        $pdf->Cell(0, 15, 'This certificate is awarded to ' . $name . ' for successfully completing the course with a score of ' . $percentage . '%', 0, 1, 'C');
        $pdf->Ln(20);
        $pdf->SetFont('helvetica', 'B', 14);

        $pdf->Cell(0, 15, '_______________________________', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Authorized Signature', 0, 1, 'C');

        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContent($pdf->Output('certificate.pdf', 'S'));

        return $response;
    }
}