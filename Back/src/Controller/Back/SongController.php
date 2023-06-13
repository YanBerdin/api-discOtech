<?php

namespace App\Controller\Back;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/song")
 */
class SongController extends AbstractController
{
    /**
     * @Route("/", name="app_back_song_index", methods={"GET"})
     */
    public function index(SongRepository $songRepository): Response
    {
        return $this->render('back/song/index.html.twig', [
            'songs' => $songRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_song_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SongRepository $songRepository): Response
    {
        $song = new Song();
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $songRepository->add($song, true);

            return $this->redirectToRoute('app_back_song_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/song/new.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_song_show", methods={"GET"})
     */
    public function show(Song $song): Response
    {
        return $this->render('back/song/show.html.twig', [
            'song' => $song,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_song_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Song $song, SongRepository $songRepository): Response
    {
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $songRepository->add($song, true);

            return $this->redirectToRoute('app_back_song_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/song/edit.html.twig', [
            'song' => $song,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_song_delete", methods={"POST"})
     */
    public function delete(Request $request, Song $song, SongRepository $songRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$song->getId(), $request->request->get('_token'))) {
            $songRepository->remove($song, true);
        }

        return $this->redirectToRoute('app_back_song_index', [], Response::HTTP_SEE_OTHER);
    }
}
