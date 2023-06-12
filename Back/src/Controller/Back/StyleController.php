<?php

namespace App\Controller\Back;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/style")
 */
class StyleController extends AbstractController
{
    /**
     * @Route("/", name="app_back_styles_index", methods={"GET"})
     */
    public function index(StyleRepository $styleRepository): Response
    {
        return $this->render('back/style/index.html.twig', [
            'styles' => $styleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_styles_new", methods={"GET", "POST"})
     */
    public function new(Request $request, StyleRepository $styleRepository): Response
    {
        $style = new Style();
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $styleRepository->add($style, true);

            return $this->redirectToRoute('app_back_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/style/new.html.twig', [
            'style' => $style,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_styles_show", methods={"GET"})
     */
    public function show(Style $style): Response
    {
        return $this->render('back/style/show.html.twig', [
            'style' => $style,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_styles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Style $style, StyleRepository $styleRepository): Response
    {
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $styleRepository->add($style, true);

            return $this->redirectToRoute('app_back_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/style/edit.html.twig', [
            'style' => $style,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_styles_delete", methods={"POST"})
     */
    public function delete(Request $request, Style $style, StyleRepository $styleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$style->getId(), $request->request->get('_token'))) {
            $styleRepository->remove($style, true);
        }

        return $this->redirectToRoute('app_back_style_index', [], Response::HTTP_SEE_OTHER);
    }
}
