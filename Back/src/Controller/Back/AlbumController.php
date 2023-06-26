<?php

namespace App\Controller\Back;

use App\Entity\Album;
use App\Entity\Song;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="app_back_album_index", methods={"GET"})
     */
    public function index(AlbumRepository $albumRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Get the sorting order from the request, default to 'ASC' if not provided
        $order = $request->query->get('order', 'ASC');
        
        // Get the limit of items per page from the request, default to 20 if not provided
        $limit = $request->query->getInt('limit', 20);
    
        // Retrieve albums from the repository based on the provided sorting order
        $albums = $albumRepository->findByAlbumOrder($order);
    
        // Paginate the albums using the PaginatorInterface
        $pagination = $paginator->paginate($albums, $request->query->getInt('page', 1), $limit);
        
        return $this->render('back/album/index.html.twig', [
            'albums' => $pagination,
            'order' => $order,
            'limits' => [10, 20, 50], // List of options for the number of items per page
            'currentLimit' => $limit, // Currently selected value for the number of items per page
        ]);
    }
    /**
     * @Route("/new", name="app_back_album_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AlbumRepository $albumRepository): Response
    {
        $album = new Album();

        // dummy code - add some example tags to the task
        // (otherwise, the template will render an empty list of tags)
        $song1 = new Song();
        $song1->setTrackNb(1);
        $song1->setTitle('title1');
        $song1->setDuration(time());
        $song1->setPreview('song');
        $album->getSongs()->add($song1);

        $song2 = new Song(); 
        $song2->setTrackNb(2);
        $song2->setTitle('title2');
        $song2->setDuration(time());
        $song2->setPreview('song2');
        $album->getSongs()->add($song2);

        // end dummy code


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
     * @Route("/{id}", name="app_back_album_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        return $this->render('back/album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_album_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        // Create the form for editing the album, pre-filled with the album's data
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the updated album to the repository and persist it
            $albumRepository->add($album, true);
    
            // Redirect to the album index page
            return $this->redirectToRoute('app_back_album_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // Render the edit form template, passing the album entity and the form to the view
        return $this->renderForm('back/album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }
    

    /**
     * @Route("/{id}", name="app_back_album_delete", methods={"POST"})
     */
    public function delete(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        // Check if the CSRF token is valid for the delete action
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            // Remove the album from the repository and persist the changes
            $albumRepository->remove($album, true);
        }
    
        // Redirect to the album index page
        return $this->redirectToRoute('app_back_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
