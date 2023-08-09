<?php

namespace App\Controller\Api;

use App\Entity\Song;
use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function read($id,SongRepository $songRepository): JsonResponse
    {
        $song = $songRepository->find($id);
        // 404 Managment
        if ($song === null){

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
     * @Route("api/songs/{id}",name="app_api_song_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     * 
     * @param Request $request 
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
                    "song_browse"
                    
                ]
            ]);
    }

    /**
     * Add new song
     * 
     * @param Request $request 
     * @param SerializerInterface $serializerInterface
     * @param SongRepository $songRepository
     * @return JsonResponse
     * 
     * @Route("/api/songs", name="app_api_song_add", methods={"POST"})
     */

    public function add(Request $request, SerializerInterface $serializerInterface, SongRepository $songRepository)
    {
        // Select Json content
        $jsonContent =$request->getContent();

        $newSong = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // type to object we want to deserialized
            Song::class,
            // Format
            "json"
        );
        $songRepository->add($newSong, true);
        return $this->json(
            // data
            $newSong,
            // status code
            Response::HTTP_CREATED,
            //headers
            [],
            //context
            [
                "groups"=>
                [
                    "song_browse"
                ]
            ]
        );
    }

    /**
     * Delete specific song
     * 
     * @param int $id
     * @param SongRepository $songRepository
     * 
     * @Route("api/songs/{id}",name="app_api_song_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */

     public function delete ($id, SongRepository $songRepository)
     {
        $song = $songRepository->find($id);
        $songRepository->remove($song, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
     }
}
