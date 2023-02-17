<?php
// src/Controller/Controller.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController{

    #[Route('/vysledek', name: 'result')]
    public function result(): Response {
        return $this->render('result.html.twig');
    }
}
?>

