<?php

namespace App\Controller\Api;

use App\Repository\FavoritesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FavoriteController extends AbstractController
{
   /**
     * Liste all favorites
     * 
     * @Route("/api/favorites", name="app_api_favorite_browse", methods={"GET"})
     */
    public function browse(FavoritesRepository $favoriteRepository): JsonResponse
    {
        // List all favorites
        $allFavorites = $favoriteRepository->findAll();

        return $this->json(
            // Data
            $allFavorites,
            // Status code
            200,
            // HTTP headers
            [],
            // Serialization contexts
            [
                "groups" =>
                [
                    "favorite_browse"
                ]
            ]

        );     
    }

    /**
     * Select specific Favorite
     *
     * @param int $id
     * @param FavoritesRepository $favoriteRepository
     * @return JsonResponse
     * 
     * @Route("api/favorites/{id}",name="app_api_favorite_read", requirements={"id"="\d+"}, methods={"GET"})
     */

     public function read($id,FavoritesRepository $favoriteRepository): JsonResponse
     {
         $favorite = $favoriteRepository->find($id);
         // 404 Managment
         if ($favorite === null){
            
             return $this->json(
                 // error message
                 [
                     "message" => "Cette musique n'existe pas"
                 ],
                 // status code : 404
                 Response::HTTP_NOT_FOUND
             );
         }
         return $this->json(
             // Alone favorite data
             $favorite, 
             //code return
             200, 
             //header HTTP
             [], 
             //context of serialization
             [
                 "groups" => 
                 [
                     "favorite_browse",
                     "favorite_read" 
                 ]
             ]);
     }

      /**
     * Add new Album
     * 
     * @param Request $request la requete
     * @param SerializerInterface $serializerInterface
     * @param FAvoritesRepository $favoriteRepository
     * @return JsonResponse
     * 
     * @Route("/api/favorites", name="app_api_favorite_add", methods={"POST"})
     */

    public function add(Request $request, SerializerInterface $serializerInterface, FavoritesRepository $favoriteRepository)
    {
        // Select Json content
        $jsonContent =$request->getContent();

        $newFavorite = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // type to object we want to deserialized
            Favorite::class,
            // Format
            "json"
        );
        $favoriteRepository->add($newFavorite, true);
        return $this->json(
            // data
            $newFavorite,
            // status code
            Response::HTTP_CREATED,
            //headers
            [],
            //context
            [
                "groups"=>
                [
                    "favorite_read"
                ]
            ]
        );
    }

    /**
     * Delete specific favorite
     * 
     * @param int $id
     * @param FavoritesRepository $favoriteRepository
     * 
     * @Route("api/favorites/{id}",name="app_api_favorite_edit", requirements={"id"="\d+"}, methods={"DELETE"})
     */

     public function delete ($id, FavoritesRepository $favoriteRepository)
     {
        $favorite = $favoriteRepository->find($id);
        $favoriteRepository->remove($favorite, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
     }
}
