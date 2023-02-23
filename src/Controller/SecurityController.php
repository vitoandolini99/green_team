<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class SecurityController extends AbstractController{


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/register', name: 'register')]
    public function reg(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->request->get('username') !== Null && $request->request->get('password') !== Null) {
            $entityManager = $doctrine->getManager();

            $username = $request->request->get('username');
            $user = new User();
            $user->setUsername($username);

            $psswd = $request->request->get('password');;
            $user->setPassword($psswd);

            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('register.html.twig');
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

            $userRepository = $this->entityManager->getRepository(User::class);
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