<?php

namespace App\Controller\Admin;

use App\Entity\StaticStorage\UserStaticStorage;
use App\Entity\User;
use App\Form\Admin\EditUserFormType;
use App\Form\Handler\UserFormHandler;
use App\Utils\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/list", name="list")
     */
    public function list(UserRepository $userRepository)
    {
        $users = $userRepository->findBy(['isDeleted' => false], ['id' => 'DESC']);

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @param Request $request
     * @param User|null $user
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @Route("/add", name="add")
     */
    public function edit(Request $request, UserFormHandler $userFormHandler, User $user = null): Response
    {
        if(!$user) {
            $user = new User();
        }

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $userFormHandler->processEditForm($form);

            $this->addFlash('success', 'Your changes were saved!');

            return $this->redirectToRoute('admin_user_edit', [
                'id' => $user->getData()->getId(),
            ]);
        }

        if($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Something went wrong. Please check your form.');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(User $user, UserManager $userManager): Response
    {
        $userManager->remove($user);

        $this->addFlash('warning', 'The user was successfully deleted!');

        return $this->redirectToRoute('admin_user_list');
    }
}