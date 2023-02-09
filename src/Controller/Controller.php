<?php
// src/Controller/MainController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// TODO use App\Entity\User;

class Controller extends AbstractController{

    #[Route('/', name: 'homepage')]
    public function home(): Response {
        return $this->render('index.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Create a new user object
        $user = new User();

        // Get the user data from the request
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // Set the user data
        $user->setUsername($username);
        $user->setPassword($passwordEncoder->encodePassword($user, $password));

        // Save the user to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirect to the login page
        return $this->redirectToRoute('login');
    }

    #[Route('/login', name: 'login')]
    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Get the username and password from the request
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // Check if the user exists in the database
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);

        if (!$user) {
            //TODO error
        }

        // Check if the password is correct
        if (!$passwordEncoder->isPasswordValid($user, $password)) {
            //TODO error
        }

        // The user is logged in, save their information to the session
        $request->getSession()->set('user', $user);

        // Redirect to the profile page
        return $this->redirectToRoute('profile');
    }
}