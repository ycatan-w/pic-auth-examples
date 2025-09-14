<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Crayon\PicAuth\AuthManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route(path: '/register', name: 'app_register')]
    public function register(AuthManager $authManager, EntityManagerInterface $entityManager, Request $request): Response
    {
        // $request->getSession()->remove('user_id');
        // $request->getSession()->remove('username');
        // $request->getSession()->remove('user_image');
        $form = $this->createFormBuilder()
           ->add('username', TextType::class, [
               'required' => true,
           ])
           ->add('image', FileType::class, [
               'required' => true,
               'attr'     => [
                   'accept' => '.png,.jpg,.jpeg',
               ],
           ])
           ->add('save', SubmitType::class, ['label' => 'Register'])
           ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();
            // var_dump($userData);
            // exit;
            $authStamp = $authManager->stamp($userData['image']->getPathname());

            $user = new User();
            $user->setUsername($userData['username']);
            $user->setHash($authStamp->hash);
            $user->setToken($authStamp->token);
            $entityManager->persist($user);
            $entityManager->flush();

            $request->getSession()->set('user_id', $user->getId());
            $request->getSession()->set('username', $user->getUsername());
            $request->getSession()->set('user_image', $authStamp->stampedImage);

            return $this->redirectToRoute('app_registered');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/registered', name: 'app_registered')]
    public function registered(Request $request): Response
    {
        $userId    = $request->getSession()->get('user_id');
        $username  = $request->getSession()->get('username');
        $userImage = $request->getSession()->get('user_image');
        if (!$userId || !$username || !$userImage) {
            return $this->redirectToRoute('app_register');
        }

        return $this->render('register/register_complete.html.twig', [
            'id'       => $userId,
            'username' => $username,
            'image'    => $userImage,
        ]);
    }
}
