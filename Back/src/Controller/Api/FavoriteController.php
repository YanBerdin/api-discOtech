<?php

namespace App\Controller\Api;

use App\Entity\Album;
use App\Entity\Favorites;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\FavoritesRepository;
use App\Repository\UserRepository;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FavoriteController extends AbstractController
{

   /**
     * Liste all favorites for current user
     * 
     * @Route("/api/favorites", name="app_api_favorite_browse", methods={"GET"})
     */
    public function browse(FavoritesRepository $favoriteRepository, UserRepository $userRepository): JsonResponse
    {
        // * For test Only (use an existing id: check DB) =================
        $user = $userRepository->find(2);
        // * ==============================================================
        
        /** @var User $user */
        //$user = $this->getUser();

        // List all favorites for currrent user
        $allFavorites = $user->getFavorites();

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
     * add favorites for current user account
     * 
     * @Route("/api/albums/{id}/favorites", name="app_api_favorite_add", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function add(Album $album, AlbumRepository $albumRepository, FavoritesRepository $favoriteRepository, UserRepository $userRepository)
    {
        // * For test Only (use an existing id: check DB) =================
        $user = $userRepository->find(1);
        // * ==============================================================

        // Select current user
        /** @var User $user */
        //$user = $this->getUser();

        // Use custom method (into userRepository) to search if favorite already exist in DB for current user
        $alreadyInFavorite = $userRepository->searchIfUserHasFavorite($album);

        if($alreadyInFavorite) {
            return $this->json(
                ["message" => "L'album est déjà dans les favoris."],
                Response::HTTP_BAD_REQUEST
            );
        }

        // Create new favorite
        $favorites = new Favorites();

        // Set Id
        $favorites->setAlbum($album);
        $favorites->setUser($user);

        // confirm and save into DB
        $favoriteRepository->add($favorites,true);

        return $this->json(
            // Data
            ["message" => "L'album a bien été ajouté aux favoris"],
            // Status code
            Response::HTTP_CREATED
      
        );     
    }

    /**
     * remove favorites for current user account
     * 
     * @Route("/api/albums/{id}/favorites", name="app_api_favorite_remove", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function remove($id, AlbumRepository $albumRepository, FavoritesRepository $favoriteRepository, UserRepository $userRepository)
    {
        // * For test Only (use an existing id: check DB) =================
        $user = $userRepository->find(2);
        // * ==============================================================

        // Select current user
        /** @var User $user */
        //$user = $this->getUser();

        $album = $albumRepository->find($id);

        // Use custom method (into userRepository) to search if favorite already exist in DB for current user
        /** @var Favorites $favorite */
        $favorite = $favoriteRepository->searchFavoriteWithAlbum($album, $user);

        $favoriteTest = $favorite[0];
        //dd($favoriteTest);

        $favoriteRepository->remove($favoriteTest, true);
        
        return $this->json(
            // Data
            ["message" => "L'album a bien été retiré des favoris"],
            // Status code
            Response::HTTP_OK
      
        );     
    }
}
