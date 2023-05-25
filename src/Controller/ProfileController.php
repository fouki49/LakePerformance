<?php

namespace App\Controller;

use App\Form\InformationModificationFormType;
use App\Form\PasswordModificationFormType;
use App\Core\Notification;
use App\Core\NotificationColor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserInterface $user, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //We have a user connected
        $user = $this->getUser();
        $InformationForm = $this->createForm(InformationModificationFormType::class, $user);
        $InformationForm->handleRequest($request);

        $PasswordForm = $this->createForm(PasswordModificationFormType::class, $user);
        $PasswordForm->handleRequest($request);

        if ($PasswordForm->isSubmitted() && $PasswordForm->isValid()) {
            //valide si le oldPassword est pareil que le passord
            if ($userPasswordHasher->isPasswordValid($user, $PasswordForm->get('oldPassword')->getData())) {
                //hash le nouveau mot de passe
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $PasswordForm->get('newPassword')->getData()
                    )
                );
                $this->addFlash(
                    'password',
                    new Notification('success', 'The password has been changed', NotificationColor::SUCCESS)
                );
                $entityManager->persist($user);
                $entityManager->flush();
            } 
        }

        if ($InformationForm->isSubmitted() && $InformationForm->isValid()) {
            $this->addFlash(
                'informations',
                new Notification('success', 'The account informations has been changed', NotificationColor::SUCCESS)
            );
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('profile/index.html.twig', [
            'InformationModificationForm' => $InformationForm->createView(),
            'PasswordModificationForm' => $PasswordForm->createView(),
            'search_category' => $request->query->get('category')
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profile');
        }

        $notification = null;
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error != null && $error->getMessageKey() === 'Invalid credentials.') {
            $message = "Wrong username and password combination.";
            $notification = new Notification('error', $message, NotificationColor::WARNING);
        }

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('profile/login.html.twig', [
            'last_username' => $lastUsername,
            'notification' => $notification,
            'search_category' => $request->query->get('category')
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {

        throw new \Exception("Don't forget to activate logout in security.yaml");
    }
}
