<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
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

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/users/role/{id}", name="user_role")
     */
    public function changeRole(User $user, EntityManagerInterface $em) 
    {
        // var_dump($user->getRoles()); die;
        foreach($user->getRoles() as $role){
            if($role =='ROLE_ADMIN'){
                $user->setRoles([]);
                $em->persist($user);
                $em->flush();
            return $this->redirectToRoute("users_index");
            }    
            if($role == "ROLE_USER"){
                $user->setRoles(["ROLE_ADMIN"]);
                $em->persist($user);
                $em->flush();
            return $this->redirectToRoute("users_index");
            }
        }
        
    }

    /**
     * @Route("/users/delete/{id}", name="user_del")
     */
    public function delUser(User $user = null, EntityManagerInterface $em) : Response
    {
        if($user) {
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute("users_index");
    }

    /**
     * @Route("/users", name="users_index")
     */
    public function index(UserRepository $repo): Response
    {
                $users = $repo->findAll();

        return $this->render('security/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response {
        return $this->render('security/show.html.twig', ['user' => $user]);
    }
}
