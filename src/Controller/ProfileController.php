<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        // Redirect to login if the user is not authenticated
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Render the profile page with the user data
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(): Response
    {
        // This method is intended to be intercepted by the Symfony security system
        throw new \Exception('This should never be reached!');
    }

    #[Route('/profile/edit', name: 'app_edit_username')]
    public function editUsername(): Response
    {
        // Redirect to login if the user is not authenticated
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Render the edit username page with the user data
        return $this->render('profile/edit_username.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/change-password', name: 'app_change_password', methods: ['POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {

        // Get the currently authenticated user
        $user = $this->getUser();
    
        // Redirect to login if the user is not authenticated
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
    
        // Get the old password, new password, and confirm password from the request
        $oldPassword = $request->request->get('old_password');
        $newPassword = $request->request->get('new_password');
        $confirmPassword = $request->request->get('confirm_password');
    
        // Check if the old password is correct (the error is a bug i think)
        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            $this->addFlash('danger', 'Old password incorrect.');
            return $this->redirectToRoute('app_profile');
        }
    
        // Check if the new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('danger', 'New password and confirm password do not match.');
            return $this->redirectToRoute('app_profile');
        }
    
        // Hash the new password and update the user entity (same here for the error)
        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();
    
        // Log out the user after password change
        $security->logout(false);
        $this->addFlash('success', 'Password changed successfully. Please login with new password.');
        
        // Redirect to the login page
        return $this->redirectToRoute('app_login');
    }

}
