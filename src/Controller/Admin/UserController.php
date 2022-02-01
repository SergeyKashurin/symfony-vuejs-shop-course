<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
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
     * @param Category|null $category
     * @return Response
     *
     * * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @Route("/add", name="add")
     */
    public function edit(Request $request, CategoryFormHandler $categoryFormHandler, Category $category = null): Response
    {
        /*
        $editCategoryModel = EditCategoryModel::makeFromCategory($category);

        $form = $this->createForm(EditCategoryFormType::class, $editCategoryModel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $category = $categoryFormHandler->processEditForm($editCategoryModel);

            $this->addFlash('success', 'Your changes were saved!');

            return $this->redirectToRoute('admin_category_edit', [
                'id' => $category->getId(),
            ]);
        }

        if($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Something went wrong. Please check your form.');
        }
        */
        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            #'form' => $form->createView(),
        ]);
    }

    /**
     * @param Category $category
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(Category $category, CategoryManager $categoryManager): Response
    {
        /*
        $categoryManager->remove($category);

        $this->addFlash('warning', 'The category was successfully deleted!');
          */
        return $this->redirectToRoute('admin_category_list');
    }
}