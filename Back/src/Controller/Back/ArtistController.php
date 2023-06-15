<?php

namespace App\Controller\Back;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/artist")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="app_back_artist_index", methods={"GET"})
     */
    public function index(ArtistRepository $artistRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allArtists = $artistRepository->findAll();

        $allArtists = $paginator->paginate($allArtists, $request->query->getInt('page', 1),20);

        return $this->render('back/artist/index.html.twig', [
            'artists'=> $allArtists
        ]);
    }

    /**
     * @Route("/new", name="app_back_artist_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArtistRepository $artistRepository): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->add($artist, true);

            return $this->redirectToRoute('app_back_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_artist_show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        return $this->render('back/artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_artist_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->add($artist, true);

            return $this->redirectToRoute('app_back_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_artist_delete", methods={"POST"})
     */
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
        }

        return $this->redirectToRoute('app_back_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
