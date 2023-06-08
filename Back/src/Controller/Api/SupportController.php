<?php

namespace App\Controller\Api;

use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportController extends AbstractController
{
    /**
     * @Route("/api/supports", name="app_api_support_browse")
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
}
