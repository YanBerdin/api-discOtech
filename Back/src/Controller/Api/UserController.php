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
     * Create User account from FrontOffice by visitor
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return void
     * 
     * @Route("/api/users/signup", name="app_api_user_signUp", methods={"POST"})
     */
    public function SignUp(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        // Select data from Front form
        $data = json_decode($request->getContent(), true);
     
        $email = $data["email"];
        $password = $data["password"];
        $firstname = $data["firstname"];
        $lastname = $data["lastname"];
        $avatar = $data["avatar"];
        
        $existingUser = $userRepository->findByEmail($email);
        //dd($existingUser);

        // Condition for existing account 
        if ($existingUser != null) {
            return $this->json(
                // data
                ["message"=>"Cet utilisateur existe déjà"],
                // status code
                Response::HTTP_OK);
        }
        else{
            // Create new User
            $user = new User();
            
            $user->setEmail($email);

            $user->setRoles(["ROLE_USER"]); // Set ROLE_USER by default.

            // Manage password with hash
            $plaintextPassword =  $password;
            $passwordHashed = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($passwordHashed);

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setAvatar($avatar);

            // Flush (Confirm add) new user into Database
            $userRepository->add($user,true);
        }

        return $this->json(
            // data
            ["message" => "Votre compte à bien été créé"],
            // status code
            Response::HTTP_CREATED,
        );
    }

    /**
     * Select current user
     *
     * @return JsonResponse
     * 
     * @Route("api/users/detail",name="app_api_user_read", methods={"GET"})
     */
    public function read(UserRepository $userRepository): JsonResponse
    {
        // * For test Only (use an existing id: check DB) =============
        //$user = $userRepository->find(19);
        // * ==========================================================

        /** @var User $user */
        $user = $this->getUser();


        return $this->json(
            // Alone user data
            $user, 
            //code return
            200, 
            //header HTTP
            [], 
            //context of serialization
            [
                "groups" => 
                [
                    "user_detail" 
                ]
            ]);
    }

    /**
     * Function for editing user firstname
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @return void
     * 
     * @Route("/api/users/edit/firstname", name="app_api_user_edit_firstname", methods={"PUT", "PATCH"})
     */
    public function editFirstname (UserRepository $userRepository, Request $request)
    {

        /** @var User $user */
        $user = $this->getUser();

        // * For test Only (use an existing id: check DB) =================
        //$user = $userRepository->find(19);
        // * ==========================================================
     
        $data = json_decode($request->getContent(), true);
        //dd($data);

        // get new firstname
        $newFirstname = $data["firstname"];

        // get current firstname
        $currentFirstname = $user->getFirstname();

        if ($newFirstname == $currentFirstname){
            return $this->json(
                // data
                ["message" => "Prénom identique"],
                // status code
                Response::HTTP_OK,
            ); 
        }
        else {
            // Set new Firstname
            $user->setFirstname($newFirstname);

            // Confirm and flush
            $userRepository->add($user,true);
        }

        return $this->json(
            // data
            ["message" => "Votre prénom a bien été modifié"],
            // status code
            Response::HTTP_OK,
        );
    }

    /**
     * Function for editing user lastname
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @return void
     * 
     * @Route("/api/users/edit/lastname", name="app_api_user_edit_lastname", methods={"PUT", "PATCH"})
     */
    public function editLastname (UserRepository $userRepository, Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        // * For test Only (use an existing id: check DB) =================
        //$user = $userRepository->find(19);
        // * ==========================================================
     
        $data = json_decode($request->getContent(), true);
        //dd($data);

        // get new lastname
        $newLastname = $data["lastname"];

        // get current lastname
        $currentLastname = $user->getLastname();

        if ($newLastname == $currentLastname){
            return $this->json(
                // data
                ["message" => "Nom identique"],
                // status code
                Response::HTTP_OK,
            ); 
        }
        else {
            // Set newlastname
            $user->setLastname($newLastname);

            // Confirm and flush
            $userRepository->add($user,true);
        }

        return $this->json(
            // data
            ["message" => "Votre nom a bien été modifié"],
            // status code
            Response::HTTP_OK,
        );
    }

    /**
     * Function for editing user email
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @return void
     * 
     * @Route("/api/users/edit/email", name="app_api_user_edit_email", methods={"PUT", "PATCH"})
     */
    public function editEmail (UserRepository $userRepository, Request $request)
    {
        // * For test Only (use an existing id: check DB) =============
        //$user = $userRepository->find(5);
        // * ==========================================================

        /** @var User $user */
        $user = $this->getUser();

     
        $data = json_decode($request->getContent(), true);
        //dd($data);

        // get new email
        $newEmail = $data["email"];

        // get current email
        $currentEmail = $user->getEmail();

        if ($newEmail == $currentEmail){
            return $this->json(
                // data
                ["message" => "Email identique"],
                // status code
                Response::HTTP_OK,
            ); 
        }
        else {
            // Set new Email
            $user->setEmail($newEmail);

            // Confirm and flush
            $userRepository->add($user,true);
        }

        return $this->json(
            // data
            ["message" => "Votre Email a bien été modifié"],
            // status code
            Response::HTTP_OK,
        );
    }

    /**
     * Function for editing user avatar
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @return void
     * 
     * @Route("/api/users/edit/avatar", name="app_api_user_edit_avatar", methods={"PUT", "PATCH"})
     */
    public function editAvatar (UserRepository $userRepository, Request $request)
    {
        // * For test Only (use an existing id: check DB) =============
        //$user = $userRepository->find(19);
        // * ==========================================================

        /** @var User $user */
        $user = $this->getUser();

     
        $data = json_decode($request->getContent(), true);
        //dd($data);

        // get new avatar
        $newAvatar = $data["avatar"];

        // get current avatar
        $currentAvatar = $user->getAvatar();

        if ($newAvatar == $currentAvatar){
            return $this->json(
                // data
                ["message" => "Image de profil identique"],
                // status code
                Response::HTTP_OK,
            ); 
        }
        else {
            // Set new Avatar
            $user->setAvatar($newAvatar);

            // Confirm and flush
            $userRepository->add($user,true);
        }

        return $this->json(
            // data
            ["message" => "Votre image de profil a bien été modifiée"],
            // status code
            Response::HTTP_OK,
        );
    }

    /**
     * Function for editing user password
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return void
     * 
     * @Route("/api/users/edit/password", name="app_api_user_edit_password", methods={"PUT", "PATCH"})
     */
    public function editPassword (UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        // * For test Only (use an existing id: check DB) =============
        //$user = $userRepository->find(19);
        // * ==========================================================

        /** @var User $user */
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);

        // get new password
        $plaintextNewPassword =  $data["password"];

        // Manage password with hash
        $NewPasswordHashed = $passwordHasher->hashPassword($user, $plaintextNewPassword);

        // Set new Password
        $user->setPassword($NewPasswordHashed);

        // Confirm and flush
        $userRepository->add($user,true);

        return $this->json(
            // data
            ["message" => "Votre mot de passe a bien été modifiée"],
            // status code
            Response::HTTP_OK,
        );
    }

    /**
     * Remove User account by User directly
     *
     * @param User $user
     * @param Request $request
     * @param UserRepository $userRepository
     * @return void
     * 
     * @Route("/api/users/delete", name="app_api_user_delete", methods={"DELETE"})
     */
    public function delete (UserRepository $userRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        // * For test Only (use an existing id: check DB) ==============
        // $user = $userRepository->find(19);
        // *  ==========================================================

        $userRepository->remove($user,true);

        return $this->json(
            // data
            ["message" => "Votre compte à bien été supprimé"],
            // status code
            Response::HTTP_NO_CONTENT,
        );
    }
}
