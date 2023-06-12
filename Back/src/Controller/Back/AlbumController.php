<?php

namespace App\Controller\Back;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/albums")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="app_back_albums_index", methods={"GET"})
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('back/album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_albums_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AlbumRepository $albumRepository): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $albumRepository->add($album, true);

            return $this->redirectToRoute('app_back_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_albums_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        return $this->render('back/album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_albums_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $albumRepository->add($album, true);

            return $this->redirectToRoute('app_back_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_albums_delete", methods={"POST"})
     */
    public function delete(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $albumRepository->remove($album, true);
        }

        return $this->redirectToRoute('app_back_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
