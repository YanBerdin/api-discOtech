<?php

namespace App\Controller\Api;

use App\Repository\FavoritesRepository;
use App\Repository\UserRepository;
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
    public function browse(FavoritesRepository $favoriteRepository, UserRepository $userRepository): JsonResponse
    {
        /** @var User $user */
        //$user = $this->getUser();

        // * For test Only (use an existing id: check DB) =================
        $user = $userRepository->find(2);
        // * ==============================================================

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

}
