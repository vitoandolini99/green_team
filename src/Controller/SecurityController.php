<?php
// src/Controller/SecurityController.php
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

class SecurityController extends AbstractController{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // create user (missing db)
        $user = new User();

        // get data
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // set data
        $user->setUsername($username);
        $user->setPassword($passwordEncoder->encodePassword($user, $password));

        // save to DB
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('login');
    }

    #[Route('/login', name: 'login')]
    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // get data
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // check for user in DB (no db)
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);

        if (!$user) {
            //TODO error
        }

        // check password match
        if (!$passwordEncoder->isPasswordValid($user, $password)) {
            //TODO error
        }

        // save user sesstion (idk if works)
        $request->getSession()->set('user', $user);
        
        return $this->redirectToRoute('profile');
    }

}