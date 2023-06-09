<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * List all users
     * 
     * @Route("/api/users", name="app_api_user_browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository): JsonResponse
    {
        // List all users
        $allUser = $userRepository->findAll();

        return $this->json(
            // Data
            $allUser,
            // Status code
            200,
            // HTTP headers
            [],
            // Serialization contexts
            [
                "groups" =>
                [
                    "user_browse"
                ]
            ]
        );     
    }

    /**
     * Select specific user
     *
     * @param int $id
     * @param UserRepository $userRepository
     * @return JsonResponse
     * 
     * @Route("api/users/{id}",name="app_api_user_read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, UserRepository $userRepository): JsonResponse
    {
        // find specific album
        $user = $userRepository->find($id);

        // 404 management
        if ($user === null){
            return $this->json(["message"=>"Cet utilisateur n'existe pas"], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user,200,[],[
                "groups" =>
                [
                    "user_browse",
                    "user_read"
                ]
            ]
        );
    }

    /**
     * Add new User
     *
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param UserRepository $userRepository
     * @return JsonResponse
     * 
     * @Route("/api/users", name="app_api_user_add", methods={"POST"})
     */
    public function add (Request $request, SerializerInterface $serializerInterface, UserRepository $userRepository )
    {
        // Select Json content
        $jsonContent = $request->getContent();

        //
        $newUser = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // Type of object we want to deserialize
            User::class,
            // Format
            "json"     
        );

        $userRepository->add($newUser, true);

        return $this->json(
            // data
            $newUser,
            // status code
            Response::HTTP_CREATED,
            // headers
            [],
            // context
            [
                "groups" =>
                [
                    "user_read"
                ]
            ]
        );     
    }

    /**
     * Edit specific user
     *
     * @param int $id
     * @param Request $request
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * @Route("api/users/{id}",name="app_api_user_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, UserRepository $userRepository, SerializerInterface $serializerInterface)
    {
        // 1. Select Json content
        $jsonContent = $request->getContent();

        // 2. Find user on Database
        $user = $userRepository->find($id);

        // 3. deserialize and update
        $serializerInterface->deserialize( 
            // data
            $jsonContent,
            // type
            Album::class, 
            // Format
            "json",
            // context
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );

        $userRepository->add($user,true);

        return $this->json(
            // data
            $user,
            // code status
            Response::HTTP_OK,
            // headers
            [],
            // context
            [
                "groups" =>
                [
                    "user_read"
                ]
            ]
        );
    }

    /**
     * Delete specific user
     *
     * @param int $id
     * @param UserRepository $userRepository
     * 
     * @Route("api/users/{id}",name="app_api_user_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        $userRepository->remove($user,true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

}
