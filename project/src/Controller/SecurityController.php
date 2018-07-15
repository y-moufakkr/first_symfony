<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/register", name="registration")
     */
    public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
          $form=$this->createForm(RegistrationType::class,$user);
      $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
             $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('login');
        }
      
        return $this->render('security/register.html.twig', [
            'controller_name' => 'SecurityController',
            'formregister'=>$form->createView()
        ]);
    }
    /**
     * @Route("/connexion", name="security_login")
     */
     public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
         $lastUsername = $utils->getLastUsername();
         dump($error);
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error'=> $error,
        ]);
    }
    /**
     * @Route("/deconnexion", name="security_logout")
     */
     public function logout()
    {
       
        
    }
}
