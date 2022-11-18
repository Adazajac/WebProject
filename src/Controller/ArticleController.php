<?php

namespace App\Controller;

use App\Entity\Article;
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
//    /**
//     * @Route("/article", name="article")
//     */
//    public function index(): Response
//    {
//        return $this->render('article/index.html.twig', [
//            'controller_name' => 'ArticleController',
//        ]);
//    }


    /**
     * @Route("/add", name="add_article")
     */
    public function create(Request $request,ManagerRegistry $managerRegistry)
    {
        $article = new Article();
        $article->setName('Deska');
        $article->setQuantity(10);

        $em = $managerRegistry->getManager();
        $em->persist($article);
        $em->flush();

        return new Response("Dodane");

    }
}
