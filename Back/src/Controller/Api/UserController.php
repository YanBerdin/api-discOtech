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
    /**
     * @Route("/api/user/signUp", name="app_api_user_signUp", methods={"POST"})
     */
    public function SignUp(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        // TODO : Voir comment on va recevoir les information du Front pour setter les infos en BDD

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("firstname");
        $lastname = $request->query->get("lastname");
        $avatar =$request->query->get("avatar");
        
        $existingUser = $userRepository->findByEmail($email);

        if ($existingUser !== null) {
            return $this->json(["message"=>"Cet utilisateur existe déjà"], Response::HTTP_OK);
        }
        else{
            $user = new User();
            $user->setEmail($email); //! A confirmer 

            $user->setRoles(["ROLE_USER"]); //* Normalement OK 

            $plaintextPassword =  $password; //TODO : Récupération du password depuis le front
            $passwordHashed = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($passwordHashed);

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setAvatar($avatar);

            $userRepository->add($user,true);
            
        }
        return $this->json(
            // data
            $user,
            // status code
            Response::HTTP_CREATED,
            //headers
            [],
            //context
            [
                "groups"=>
                [
                    "user_read"
                ]
            ]
        );
    }


    public function edit ()
    {
        # code...
    }

    public function delete ()
    {
            # code...
    }


}
