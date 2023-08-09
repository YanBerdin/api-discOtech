<?php

namespace App\Controller\Api;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ArtistController extends AbstractController
{
    /**
     * list all artists
     * 
     * @Route ("/api/artists", name="app_api_artist_browse", methods={"GET"})
     * 
     * @param artistRepository $artistRepository
     * @return JsonResponse
     */
    public function browse(ArtistRepository $Repository): JsonResponse
    {
        //list Of all artist
        $allArtists = $Repository->findAll();
 
     
        return $this->json(
            //the all Artists data
            $allArtists,
            //code return
            200,
            //header HTTP
            [],
            //context of serialization
            [
                "groups" => ["artist_browse"],
            ]
        );
    }

    /**
     * Select specific artist
     *
     * @param int $id
     * @param ArtistRepository $artistRepository
     * @return JsonResponse
     * 
     * @Route("api/artists/{id}",name="app_api_artist_read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id,ArtistRepository $artistRepository): JsonResponse
    {
        $artist = $artistRepository->find($id);
        // 404 Managment
        if ($artist === null){
            
            return $this->json(
                // error message
                [
                    "message" => "Cette artiste n'existe pas"
                ],
                // status code : 404
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            // Alone artist data
            $artist, 
            //code return
            200, 
            //header HTTP
            [], 
            //context of serialization
            [
                "groups" => 
                [
                    "artist_browse", 
                ]
            ]);
    }

    /**
     * edit artists
     *
     * @Route("api/artists/{id}",name="app_api_artist_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     * 
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param ArtistRepository $artistRepository
     */
    public function edit($id, Request $request, SerializerInterface $serializerInterface, ArtistRepository $artistRepository)
    {
        // Select Json content
        $jsonContent = $request->getContent();
        // Find artist in database
        $artist = $artistRepository->find($id);
        // Deserialize and update
        $serializerInterface->deserialize(
            // Data
            $jsonContent,
            // Type
            artist::class,
            // Format
            'json',
            // Contexte 
            [AbstractNormalizer::OBJECT_TO_POPULATE => $artist]
        );
        // Flush
        $artistRepository->add($artist, true);

        // return 200
        return $this->json(
            // Alone artist data
            $artist, 
            //code return
            200, 
            //header HTTP
            [], 
            //context of serialization
            [
                "groups" => 
                [
                    "artist_browse",
                ]
            ]);
    }

    /**
     * Add new Album
     * 
     * @param Request $request la requete
     * @param SerializerInterface $serializerInterface
     * @param ArtistRepository $artistRepository
     * @return JsonResponse
     * 
     * @Route("/api/artists", name="app_api_artist_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializerInterface, ArtistRepository $artistRepository)
    {
        // Select Json content
        $jsonContent =$request->getContent();

        $newArtist = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // type to object we want to deserialized
            Artist::class,
            // Format
            "json"
        );
        $artistRepository->add($newArtist, true);
        return $this->json(
            // data
            $newArtist,
            // status code
            Response::HTTP_CREATED,
            //headers
            [],
            //context
            [
                "groups"=>
                [
                    "artist_browse"
                ]
            ]
        );
    }

    /**
     * Delete specific artist
     * 
     * @param int $id
     * @param ArtistRepository $artistRepository
     * 
     * @Route("api/artists/{id}",name="app_api_artist_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete ($id, ArtistRepository $artistRepository)
    {
        $artist = $artistRepository->find($id);
        $artistRepository->remove($artist, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}

