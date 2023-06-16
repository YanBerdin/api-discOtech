<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    // /**
    //  * @Route("/api/user/signIn", name="app_api_user_signIn", methods={"POST"})
    //  */
    // public function SignIn(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    // {

    //     // TODO : Voir comment on va recevoir les information du Front pour setter les infos en BDD

    //     $email = $request->query->get("email","");
        
    //     $existingUser = $userRepository->findByEmail($email);

    //     if ($existingUser !== null) {
    //         return $this->json(["message"=>"Cet utilisateur existe déjà"], Response::HTTP_OK);
    //     }
    //     else{
    //         $user = new User();
    //         $user->setEmail($email); //! A confirmer 

    //         $user->setRoles(["ROLE_USER"]); //* Normalement OK 

    //         $plaintextPassword =  ; //TODO : Récupération du password depuis le front
    //         $passwordHashed = $passwordHasher->hashPassword($user, $plaintextPassword);
    //         $user->setPassword($passwordHashed);
    //         $user->setFirstname();
    //         $user->setLastname();
    //         $user->setAvatar();

    //         $userRepository->add($user,true);
            
    //     }

    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/Api/UserController.php',
    //     ]);
    // }
}
