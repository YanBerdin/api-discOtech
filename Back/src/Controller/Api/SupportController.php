<?php

namespace App\Controller\Api;

use App\Entity\Support;
use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class SupportController extends AbstractController
{
    /**
     * @Route("/api/supports", name="app_api_support_browse", methods={"GET"})
     */
    public function browse(SupportRepository $supportRepository): JsonResponse
    {
        // List all support
        $allSupports = $supportRepository->findAll();

        return $this->json(
            // Data
            $allSupports,
            // Status code
            200,
            // HTTP headers
            [],
            // Serialization contexts
            [
                "groups" =>
                [
                    "support_browse"
                ]
            ]
        );     
    }

    /**
     * Select specific support
     *
     * @param int $id
     * @param SupportRepository $supportRepository
     * @return JsonResponse
     * 
     * @Route("api/supports/{id}",name="app_api_support_read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, SupportRepository $supportRepository): JsonResponse
    {
        // find all support
        $support = $supportRepository->find($id);

        // 404 management
        if ($support === null){
            return $this->json(["message"=>"Ce support n'existe pas"], Response::HTTP_NOT_FOUND);
        }

        return $this->json($support,200,[],[
                "groups" =>
                [
                    "support_browse",
                ]
            ]
        );
    }

    /**
     * Add new Support
     *
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param SupportRepository $supportRepository
     * @return JsonResponse
     * 
     * @Route("/api/supports", name="app_api_support_add", methods={"POST"})
     */
    public function add (Request $request, SerializerInterface $serializerInterface, SupportRepository $supportRepository )
    {
        // Select Json content
        $jsonContent = $request->getContent();

        //
        $newSupport = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // Type of object we want to deserialize
            Support::class,
            // Format
            "json"
            
        );

        $supportRepository->add($newSupport, true);

        return $this->json(
            // data
            $newSupport,
            // status code
            Response::HTTP_CREATED,
            // headers
            [],
            // context
            [
                "groups" =>
                [
                    "support_browse"
                ]
            ]
        );     
    }

    /**
     * Edit specific support
     *
     * @param int $id
     * @param Request $request
     * @param SupportRepository $supportRepository
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * @Route("api/supports/{id}",name="app_api_support_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, SupportRepository $supportRepository, SerializerInterface $serializerInterface)
    {
        // 1. Select Json content
        $jsonContent = $request->getContent();

        // 2. Find support on Database
        $support = $supportRepository->find($id);

        // 3. deserialize and update
        $serializerInterface->deserialize( 
            // data
            $jsonContent,
            // type
            Support::class, 
            // Format
            "json",
            // context
            [AbstractNormalizer::OBJECT_TO_POPULATE => $support]
        );

        $supportRepository->add($support,true);

        return $this->json(
            // data
            $support,
            // code status
            Response::HTTP_OK,
            // headers
            [],
            // context
            [
                "groups" =>
                [
                    "support_browse",
                    
                ]
            ]

        );

    }

    /**
     * Delete specific support
     *
     * @param int $id
     * @param SupportRepository $supportRepository
     * 
     * @Route("api/supports/{id}",name="app_api_support_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, SupportRepository $supportRepository)
    {
        $support = $supportRepository->find($id);
        $supportRepository->remove($support,true);

        return $this->json(null, Response::HTTP_NO_CONTENT);

    }

}
