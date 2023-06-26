<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_back_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $order = $request->query->get('order', 'ASC');

        $users = $userRepository->findByUserOrder($order);

        // Get the limit of items per page from the request, default to 20 if not provided
        $limit = $request->query->getInt('limit', 20);

        $pagination = $paginator->paginate($users, $request->query->getInt('page', 1),$limit);

        return $this->render('back/user/index.html.twig', [
            'users' =>  $pagination,
            'order' => $order,
            'limits' => [10, 20, 50], // List of options for the number of items per page
            'currentLimit' => $limit, // Currently selected value for the number of items per page
        ]);
    }

    /**
     * @Route("/new", name="app_back_user_new", methods={"GET", "POST"})
     */
    public function new(
    Request $request, 
    UserRepository $userRepository, 
    UserPasswordHasherInterface $userPasswordHasherInterface
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
 
            // on le récupère de l'objet remplit par le formulaire
            $plainPassword = $user->getPassword();
            // je hash le mot de passe
            $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
            // j'oublie pas de mettre à jour mon objet
            $user->setPassword($hashedPassword);
            // je met à jour la BDD
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_user_edit", methods={"GET", "POST"})
     */
    public function edit(
    Request $request, 
    User $user, 
    UserRepository $userRepository,
    UserPasswordHasherInterface $userPasswordHasherInterface
    ): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            // on le récupère depuis la requete 
            // car on a désactivé la mise à jour auto par le formulaire
            $plainPassword = $request->request->get("password");
            
            if (!empty($plainPassword)){
                // je hash le mot de passe
                $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
                // * j'oublie pas de mettre à jour mon objet
                $user->setPassword($hashedPassword);     
            }
        
            // update Database
            $userRepository->add($user, true);
            

            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
