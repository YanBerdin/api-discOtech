<?php

namespace App\Controller\Api;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/api/albums/search", name="app_api_album_search")
     */
    public function searchAlbum(Request $request, AlbumRepository $albumRepository ): JsonResponse
    {

        $search = $request->get("search", "");
        $albumSearch = $albumRepository->findBySearch($search);

        return $this->json(
            // Data
            ["search" => $albumSearch],
            // Status code
            200,
            // HTTP headers
            [],
            // Serialization contexts
            [
                "groups" =>
                [
                    "album_browse"
                ]
            ]

        );
    }



    
}
