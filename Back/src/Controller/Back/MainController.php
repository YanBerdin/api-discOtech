<?php

namespace App\Controller\Back;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     *@Route("/back/main", name="default")
     */
    public function index(): Response
    {
        return $this->render('back/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * Return search result
     * 
     * @Route("/back/search", name="app_back_search", methods={"GET"})
     *
     * @return Response
     */
    public function search(Request $request, AlbumRepository $albumRepository, ArtistRepository $artistRepository, SongRepository $songRepository): Response
    {
        // get request => string 
        $search = $request->query->get("search", "");

        // Search album, artist and song based on search
        $albumSearch = $albumRepository->findBySearch($search);
        $artistSearch = $artistRepository->findBySearch($search);
        $songSearch = $songRepository->findBySearch($search);

        return $this->render('back/main/search.html.twig',[
            "albumSearch" => $albumSearch,
            "artistSearch" => $artistSearch,
            "songSearch" => $songSearch,

        ]);
    }
}
