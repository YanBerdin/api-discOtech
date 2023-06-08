<?php

namespace App\Controller\Api;

use App\Entity\Song;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SongController extends AbstractController
{
    /**
     * list all songs
     * 
     * @Route ("/api/songs", name="app_api_song_browse", methods={"GET"})
     * 
     * @param SongRepository $songRepository
     * @return JsonResponse
     */

    public function browse(SongRepository $songRepository): JsonResponse
    {
        //list Of all songs
        $allSongs = $songRepository->findAll();

    
        return $this->json(
            //the all songs data
            $allSongs,
            //code return
            200,
            //header HTTP
            [],
            //context of serialization
            [
                "groups" => ["song_browse"],
            ]
        );
    }

    /**
     * Select specific album
     *
     * @param int $id
     * @param SongRepository $songRepository
     * @return JsonResponse
     * 
     * @Route("api/songs/{id}",name="app_api_song_read", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function read($id,SongRepository $SongRepository): JsonResponse
    {
        $song = $SongRepository->find($id);
        // 404 Managment
        if ($song === null){
            // ! on est dans une API donc pas de HTML
            // throw $this->createNotFoundException();
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
            // Alone song data
            $song, 
            //code return
            200, 
            //header HTTP
            [], 
            //context of serialization
            [
                "groups" => 
                [
                    "song_browse",
                    "song_read" 
                ]
            ]);
    }

    /**
     * edit songs
     *
     * @Route("api/songs/{id}",name="app_api_song_read", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     * 
     * @param Request $request la requete
     * @param SerializerInterface $serializerInterface
     * @param SongRepository $songRepository
     */
    public function edit($id, Request $request, SerializerInterface $serializerInterface, SongRepository $songRepository)
    {
        // Select Json content
        $jsonContent = $request->getContent();
        // Find song in database
        $song = $songRepository->find($id);
        // Deserialize and update
        $serializerInterface->deserialize(
            // Data
            $jsonContent,
            // Type
            Song::class,
            // Format
            'json',
            // Contexte 
            [AbstractNormalizer::OBJECT_TO_POPULATE => $song]
        );
        // Flush
        $songRepository->add($song, true);

        // return 200
        return $this->json(
            // Alone song data
            $song, 
            //code return
            200, 
            //header HTTP
            [], 
            //context of serialization
            [
                "groups" => 
                [
                    "song_browse",
                    "song_read"
                ]
            ]);
    }
}
