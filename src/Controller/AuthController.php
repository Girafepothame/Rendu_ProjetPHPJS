<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function auth(Request $request): Response
    {
        $session = $request->getSession();
        
        // Check if the user is redirected from the squad builder
        if ($request->query->get('redirect') === 'squad_builder') {
            $this->addFlash('info', 'You must be logged in to access the Squad Builder.');
        }
    
        return $this->render('auth/index.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->render('auth/index.html.twig');
    }
    
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');
    
        // Validate input data
        if (empty($username) || empty($password)) {
            $this->addFlash('danger', 'Invalid data');
            return $this->redirectToRoute('app_auth');
        }
        
        // Check if passwords match
        if ($password !== $confirmPassword) {
            $this->addFlash('danger', 'Passwords do not match');
            return $this->redirectToRoute('app_auth');
        }
    
        // Check if the username is already taken
        if ($userRepository->findOneBy(['username' => $username])) {
            $this->addFlash('danger', 'Username already taken');
            return $this->redirectToRoute('app_auth');
        }
    
        // Create a new user and save to the database
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles(['ROLE_USER']);
    
        $entityManager->persist($user);
        $entityManager->flush();
    
        $this->addFlash('success', 'User registered successfully');
        return $this->redirectToRoute('app_auth');
    }
}
