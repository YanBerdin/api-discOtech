<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user/signUp", name="app_api_user_signUp", methods={"POST"})
     */
    public function SignUp(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        // TODO : Voir comment on va recevoir les information du Front pour setter les infos en BDD

        $email = $request->get("email");
        $password = $request->get("password");
        $firstname = $request->get("firstname");
        $lastname = $request->get("lastname");
        $avatar =$request->get("avatar");
        
        //$existingUser = $userRepository->findByEmail($email);

        // if ($existingUser !== null) {
        //     return $this->json(
        //         // data
        //         ["message"=>"Cet utilisateur existe déjà"],
        //         // status code
        //         Response::HTTP_OK);
        // }
        // else{
            $user = new User();
            
            $user->setEmail($email);

            $user->setRoles(["ROLE_USER"]); //* Normalement OK 

            $plaintextPassword =  $password; //TODO : Récupération du password depuis le front
            $passwordHashed = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($passwordHashed);

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setAvatar($avatar);

            $userRepository->add($user,true);
            
        // }
        return $this->json(
            // data
            ["message" => "Votre compte à bien été créé"],
            // status code
            Response::HTTP_CREATED,
        );
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return void
     * 
     * @Route("/api/user/edit", name="app_api_user_edit", methods={"PUT", "PATCH"})
     */
    public function edit (UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        /** @var User $user */
        $user = $this->getUser();
     
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("firstname");
        $lastname = $request->query->get("lastname");
        $avatar =$request->query->get("avatar");

        $user->setEmail($email); //! A confirmer 

        $plaintextPassword =  $password; //TODO : Récupération du password depuis le front
        $passwordHashed = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($passwordHashed);

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setAvatar($avatar);

        $userRepository->add($user,true);

        return $this->json(
            // data
            ["message" => "Votre compte à bien été modifié"],
            // status code
            Response::HTTP_OK,
        );

    }

    public function delete (User $user, Request $request, UserRepository $userRepository)
    {
        if ($this->isCsrfTokenValid("edit".$user->getId(), $request->request->get("_token")))
        {
            $userRepository->remove($user,true);
        }
        return $this->json(
            // data
            ["message" => "Votre compte à bien été modifié"],
            // status code
            Response::HTTP_NO_CONTENT,
        );
    }


}
