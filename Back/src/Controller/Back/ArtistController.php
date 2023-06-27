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
        $order = $request->query->get('order', 'ASC');

        // Get the limit of items per page from the request, default to 20 if not provided
        $limit = $request->query->getInt('limit', 20);

        $artists= $artistRepository->findByArtistorder($order);

        $pagination = $paginator->paginate($artists, $request->query->getInt('page', 1), $limit);

        return $this->render('back/artist/index.html.twig', [
            'artists'=> $pagination,
            'order' => $order,
            'limits' => [10, 20, 50], // List of options for the number of items per page
            'currentLimit' => $limit, // Currently selected value for the number of items per page
        ]);
    }

    /**
     * @Route("/new", name="app_back_artist_new", methods={"POST"})
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
     * @Route("/{id}/edit", name="app_back_artist_edit", methods={"PUT", "PATCH"})
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
     * @Route("/{id}", name="app_back_artist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
        }

        return $this->redirectToRoute('app_back_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
