<?php

namespace App\Controller\Api;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ReviewController extends AbstractController
{

    /**
     * Select specific review
     *
     * @param int $id
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     * 
     * @Route("api/reviews/{id}",name="app_api_review_read", requirements={"id"="\d+"}, methods={"GET"})
     */
     public function read($id,ReviewRepository $reviewRepository): JsonResponse
     {
         $review = $reviewRepository->find($id);
         // 404 Managment
         if ($review === null){
            
             return $this->json(
                 // error message
                 [
                     "message" => "Ce commentaire n'existe pas"
                 ],
                 // status code : 404
                 Response::HTTP_NOT_FOUND
             );
         }
         return $this->json(
             // Alone review data
             $review, 
             //code return
             200, 
             //header HTTP
             [], 
             //context of serialization
             [
                 "groups" => 
                 [
                     "review_read",
                    
                 ]
             ]);
     }

    /**
     * Add new reviews
     * 
     * @param Request $request 
     * @param SerializerInterface $serializerInterface
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     * 
     * @Route("/api/reviews", name="app_api_review_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializerInterface, ReviewRepository $reviewRepository)
    {
        // Select Json content
        $jsonContent =$request->getContent();

        $newReview = $serializerInterface->deserialize(
            // data to transform
            $jsonContent,
            // type to object we want to deserialized
            Review::class,
            // Format
            "json"
        );
        $reviewRepository->add($newReview, true);
        return $this->json(
            // data
            $newReview,
            // status code
            Response::HTTP_CREATED,
            //headers
            [],
            //context
            [
                "groups"=>
                [
                    "review_read"
                ]
            ]
        );
    }

    /**
     * Delete specific review
     * 
     * @param int $id
     * @param ReviewRepository $reviewRepository
     * 
     * @Route("api/reviews/{id}",name="app_api_review_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
     public function delete ($id, ReviewRepository $reviewRepository)
     {
        $review = $reviewRepository->find($id);
        $reviewRepository->remove($review, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
     }
}
