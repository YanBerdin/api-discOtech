<?php

namespace App\Controller\Api;

use App\Entity\Style;
use App\Repository\StyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class StyleController extends AbstractController
{
    /**
     * List all styles
     * 
     * @Route("/api/styles", name="app_api_style_browse", methods={"GET"})
     */
    public function browse(StyleRepository $styleRepository): JsonResponse
    {
        // List all styles
        $allStyles = $styleRepository->findAll();

        return $this->json(
            // Data
            $allStyles,
            // Status code
            200,
            // Headers
            [],
            // Serialization contexts
            [
                "groups" =>["style_browse"]]
        );
    }

   /**
    * Select specific style
    *
    * @param int $id
    * @param StyleRepository $styleRepository
    * @return JsonResponse
    *
    * @Route("/api/styles/{id}", name="app_api_style_read", requirements={"id"="\d+"} ,methods={"GET"})
    */
    public function read($id, StyleRepository $styleRepository): JsonResponse
    {
        // Find specific style
        $style = $styleRepository->find($id);

        // 404 Management
        if ($style === null){
            return $this->json(["message"=>"Ce style n'existe pas"],Response::HTTP_NOT_FOUND);
        }

        // if 404 test is ok: return json with specific style
        return $this->json(
            // Data
            $style,
            // Status code
            200,
            // Headers
            [],
            // Serialisation contexts
            ["groups" =>["style_read"]]
        );
    }

    /**
     * Add new style
     *
     * @param Request $request
     * @param StyleRepository $styleRepository
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * @Route("/api/styles", name="app_api_style_add", methods={"POST"})
     */
    public function add(Request $request, StyleRepository $styleRepository, SerializerInterface $serializerInterface)
    {
        // Select Json content
        $jsonContent = $request->getContent();

        $newStyle = $serializerInterface->deserialize(
            // Data
            $jsonContent,
            // Type of object we want to deserialize
            Style::class,
            // Format
            "json"
        );

        $styleRepository->add($newStyle,true);

        return $this->json(
            // Data
            $newStyle,
            // Status code
            Response::HTTP_CREATED,
            // Headers
            [],
            // Serialization contexts
            ["groups"=>["style_read"]]
        );
    }

    /**
     * Edit specific style
     *
     * @param int $id
     * @param Request $request
     * @param StyleRepository $styleRepository
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * @Route("/api/styles/{id}", name="app_api_style_edit", methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, StyleRepository $styleRepository, SerializerInterface $serializerInterface)
    {
        // 1. Select Json content
        $jsonContent = $request->getContent();

        // 2. Find style on Database
        $style = $styleRepository->find($id);

        // 3. deserialize and update
        $serializerInterface->deserialize( 
            // data
            $jsonContent,
            // type
            Style::class, 
            // Format
            "json",
            // context
            [AbstractNormalizer::OBJECT_TO_POPULATE => $style]
            
        );

        $styleRepository->add($style, true);

        return $this->json(
            // Data
            $style,
            // Status Code
            Response::HTTP_OK,
            // Headers
            [],
            // Context
            ["groups" => ["style_read"]]
        );



    }

    /**
     * Delete specific style
     *
     * @param int $id
     * @param StyleRepository $StyleRepository
     * 
     * @Route("api/styles/{id}",name="app_api_album_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, StyleRepository $styleRepository)
    {
        $style = $styleRepository->find($id);
        $styleRepository->remove($style,true);

        return $this->json(null, Response::HTTP_NO_CONTENT);

    }

}
