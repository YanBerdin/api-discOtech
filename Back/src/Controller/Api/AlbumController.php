<?php

namespace App\Controller\Api;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AlbumController extends AbstractController
{
    /**
     * Liste all albums
     * 
     * @Route("/api/albums", name="app_api_album_browse", methods={"GET"})
     */
    public function browse(AlbumRepository $albumRepository): JsonResponse
    {
        // List all albums
        $allAlbums = $albumRepository->findAll();

        return $this->json(
            // Data
            $allAlbums,
            // Status code
            200,
            // HTTP headers
            [],
            // Seraialization contexts
            [
                "groups" =>
                [
                    "album_browse"
                ]
            ]

        );     
    }

    /**
     * Sélection d'un Album
     *
     * @param int $id
     * @param AlbumRepository $albumRepository
     * @return JsonResponse
     * 
     * @Route("api/albums/{id}",name="app_api_album_read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, AlbumRepository $albumRepository): JsonResponse
    {
        // find all album
        $album = $albumRepository->find($id);

        // manage 404
        if ($album === null){
            return $this->json(["message"=>"Cette album n'existe pas"], Response::HTTP_NOT_FOUND);
        }

        return $this->json($album,200,[],[
                "groups" =>
                [
                    "album_browse",
                    "album_read"
                ]
            ]
        );
    }



}
