<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// TODO use App\Entity\User;

class SecurityController extends AbstractController{

    #[Route('/register', name: 'register')]
    public function register(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        return $this->redirectToRoute('login');
    }

    #[Route('/login', name: 'login')]
    public function login(Request $request, SessionInterface $session)
    {
        if($session->get('username')) {
            return $this->redirectToRoute('homepage');
        }

        if($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            if($username === "username" && $password === "password") {
                $session->set('username', $username);
                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash('error', 'Invalid login credentials.');
            }
        }
        return $this->render('login.html.twig');
    }

    public function logout(Request $request){

    }

}