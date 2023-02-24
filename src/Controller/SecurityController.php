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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController{


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[IsGranted('ROLE_ADMIN')]
    public function adminDashboard(): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
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
            $hashedPassword = $passwordHasher->hashPassword($user, $psswd);
            $user->setPassword($hashedPassword);

            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('register.html.twig');
    }


    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }



}