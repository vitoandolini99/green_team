<?php
// src/Controller/MainController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookieController extends AbstractController{
    
    public function quizAccessCount(): Response {
        if (!isset($_COOKIE['count']))
        {
            $cookie = 1;
            setcookie("count", $cookie);
        } 
        else
        {
            $cookie = ++$_COOKIE['count'];
            setcookie("count", $cookie);
        }
    }
}
