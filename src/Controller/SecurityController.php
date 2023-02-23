<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInteuse;
use App\Entity\User;

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
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneBy(['username' => $username]);

            if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
                $session->set('username', $user->getUsername());
                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash('error', 'Invalid login credentials.');
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('login.html.twig');
    }

    public function logout(Request $request){

    }

}