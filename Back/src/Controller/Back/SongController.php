<?php

namespace App\Controller\Back;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(SongRepository $songRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $order = $request->query->get('order', 'ASC');

        // Get the limit of items per page from the request, default to 20 if not provided
        $limit = $request->query->getInt('limit', 20);

        $songs = $songRepository->findBySongOrder($order);
        
        $pagination = $paginator->paginate($songs, $request->query->getInt('page', 1), $limit);

        return $this->render('back/song/index.html.twig', [
            'songs'=>$pagination,
            'order'=>$order,
            'limits' => [10, 20, 50], // List of options for the number of items per page
            'currentLimit' => $limit, // Currently selected value for the number of items per page
        
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
     * @Route("/{id}", name="app_back_song_show", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Song $song): Response
    {
        return $this->render('back/song/show.html.twig', [
            'song' => $song,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_song_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
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
     * @Route("/{id}", name="app_back_song_delete", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function delete(Request $request, Song $song, SongRepository $songRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$song->getId(), $request->request->get('_token'))) {
            $songRepository->remove($song, true);
        }

        return $this->redirectToRoute('app_back_song_index', [], Response::HTTP_SEE_OTHER);
    }
}
