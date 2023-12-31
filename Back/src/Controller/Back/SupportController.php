<?php

namespace App\Controller\Back;

use App\Entity\Support;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/support")
 */
class SupportController extends AbstractController
{
    /**
     * @Route("/", name="app_back_support_index", methods={"GET"})
     */
    public function index(SupportRepository $supportRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $order = $request->query->get('order', 'ASC');

        $supports = $supportRepository->findBySupportOrder($order);

        // Get the limit of items per page from the request, default to 20 if not provided
        $limit = $request->query->getInt('limit', 20);

        $pagination = $paginator->paginate($supports, $request->query->getInt('page', 1), $limit);

        return $this->render('back/support/index.html.twig', [
            'supports' =>  $pagination,
            'order' => $order,
            'limits' => [10, 20, 50], // List of options for the number of items per page
            'currentLimit' => $limit, // Currently selected value for the number of items per page
        
        ]);
    }

    /**
     * @Route("/new", name="app_back_support_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SupportRepository $supportRepository): Response
    {
        $support = new Support();
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportRepository->add($support, true);

            return $this->redirectToRoute('app_back_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/support/new.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_support_show", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Support $support): Response
    {
        return $this->render('back/support/show.html.twig', [
            'support' => $support,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_support_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function edit(Request $request, Support $support, SupportRepository $supportRepository): Response
    {
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportRepository->add($support, true);

            return $this->redirectToRoute('app_back_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/support/edit.html.twig', [
            'support' => $support,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_support_delete", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function delete(Request $request, Support $support, SupportRepository $supportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$support->getId(), $request->request->get('_token'))) {
            $supportRepository->remove($support, true);
        }

        return $this->redirectToRoute('app_back_support_index', [], Response::HTTP_SEE_OTHER);
    }
}
