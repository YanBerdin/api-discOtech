<?php

namespace App\Controller\Api;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
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
        // ========== Methode 1==================
        // $data = json_decode($request->getContent(), true);
        // dd($data);
        // $search = $data["search"];
        // $albumSearch = $albumRepository->findBySearch($search);

        // ========== Methode 2==================
        $data = json_decode($request->getContent(), false);
        //dd($data);
        $albumSearch = $albumRepository->findBySearch($data->search);
        // ======================================

        return $this->json(
            // Data
            $albumSearch,
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

     /**
     * @Route("/api/artists/search", name="app_api_artist_search")
     */
    public function searchArtist(Request $request, ArtistRepository $artistRepository ): JsonResponse
    {
        
        $data = json_decode($request->getContent(), false);
        //dd($data);
        $artistSearch = $artistRepository->findBySearch($data->search);

        return $this->json(
            // Data
            $artistSearch,
            // Status code
            200,
            // HTTP headers
            [],
            // Serialization contexts
            [
                "groups" =>
                [
                    "artist_browse"
                ]
            ]

        );
    }


    /**
     * @Route("/api/albums/random", name="app_api_album_random")
     */
    public function random(AlbumRepository $albumRepository): JsonResponse
    {

        $randomAlbum = $albumRepository->displayRandomAlbums(20);

        return $this->json(
            // Data
            $randomAlbum,
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
