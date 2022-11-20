<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleAddFormType;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/add_new", name="add_new_article")
     */
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $article = new Article();

        $form = $this->createForm(ArticleFormType::class, $article);


        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $managerRegistry->getManager();
            $file = $form->get('file')->getData();
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('file_folder'),
                    $fileName
                );
                $article->setFile($fileName);
            }


            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }


        return $this->render('article/index.html.twig',
            [
                'createForm' => $form->createView()
            ]);

    }

    /**
     * @Route ("/delete/{id}", name="delete")
     */
    public function delete($id, ArticleRepository $articleRepository, ManagerRegistry $managerRegistry)
    {
        $em = $managerRegistry->getManager();
        $article = $articleRepository->find($id);
        $em->remove($article);
        $em->flush();

        //message
        $this->addFlash('success', 'Article removed correctly');


        return $this->redirect($this->generateUrl('home'));
    }

//    /**
//     * @Route ("/add/{id}", name="add")
//     */
//    public function addArticle($id, ArticleRepository $articleRepository, ManagerRegistry $managerRegistry)
//    {
//        $em = $managerRegistry->getManager();
//        $article = $articleRepository->find($id);
//        $newArticle = $article->getQuantity() + 5;
//        dd($newArticle);
//
//
//        return $this->redirect($this->generateUrl('home'));
//
//
//    }
    /**
     * @Route ("/add/{id}", name="add")
     */
    public function add(int $id, ArticleRepository $articleRepository, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $article = $articleRepository->find($id);
        $quantity = $article->getQuantity();

        $form = $this->createForm(ArticleAddFormType::class, $article);
        $form->handleRequest($request);
        $addValue = $form->get('quantity')->getData();
        if ($form->isSubmitted()) {

            $newQuantity = $quantity + $addValue;
            $article->setQuantity($newQuantity);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('article/add_article/index.html.twig',
            [
                'createForm' => $form->createView(),
                'article' => $article
            ]);
    }

    /**
     * @Route ("/release/{id}", name="release")
     */
    public function release(int $id, ArticleRepository $articleRepository, Request $request, ManagerRegistry $managerRegistr): Response
    {
        $em = $managerRegistr->getManager();
        $article = $articleRepository->find($id);
        $quantity = $article->getQuantity();

        $form = $this->createForm(ArticleAddFormType::class, $article);
        $form->handleRequest($request);
        $addValue = $form->get('quantity')->getData();
        if ($form->isSubmitted()) {

            $newQuantity = $quantity - $addValue;
            if ($newQuantity >= 0) {
                $article->setQuantity($newQuantity);
                $em->flush();
                return $this->redirect($this->generateUrl('home'));
            } else {
                $this->addFlash('success', 'Article removed correctly');
            }

        }


        return $this->render('article/release_article/index.html.twig',
            [
                'createForm' => $form->createView(),
                'article' => $article
            ]);
    }


}
