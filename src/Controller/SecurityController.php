<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/admin/register', name:'admin_register')]
    public function registerAdmin(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passHasher): Response
    {
        //Cette méthode nous permet de créer n'importe quel type d'utilisateur via un formulaire

        //Pour enregistrer un nouvel utilisateur, nous avons besoin de l'Entity Manager
        $entityManager = $doctrine->getManager();        
        //Nous créons notre formulaire interne
        $userForm = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control mt-2 mb-3',
                    ],
                ],
                'second_options' => [
                    'label' => 'Mot de passe de confirmation',
                    'attr' => [
                        'class' => 'form-control mt-2 mb-3',
                    ],
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Privilèges',
                'choices' => [
                    'Role: Client' => 'ROLE_CLIENT',
                    'Role: Admin' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription',
                'attr' => [
                    'class' => 'form-control mt-2 mb-3 btn btn-success',
                ]
            ])
            ->getForm()
        ;
        //Nous traitons les données reçues au sein de notre formulaire
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            //On récupère les informations de notre formulaire
            $data = $userForm->getData();
            //Nous créons et renseignons notre Entity User
            $user = new User;
            $user->setUsername($data['username']);
            $user->setRoles(["ROLE_USER", $data['roles']]);
            //$user->setRoles(['ROLE_CLIENT']);
            $user->setPassword($passHasher->hashPassword($user, $data['password']));
            //On persiste notre Entity
            $entityManager->persist($user);
            $entityManager->flush();
            //Après le transfert de l'instane User vers la BDD, on retourne à l'index
            return $this->redirectToRoute('app_login');
        }
        //Si notre formulaire n'est pas validé, nous le présentons à l'utilisateur
        return $this->render('blog/dataform.html.twig', [
            'formName' => 'Nouvel utilisateur',
            'dataForm' => $userForm->createView(),
        ]);

    }

}
