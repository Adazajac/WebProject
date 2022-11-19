<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
//        $item = $articleRepository->find()


        $search = $request->query->get('q');
        if ($search) {
            $article = $articleRepository->search($search);
        } else {
            $article = $articleRepository->findAll();
        }

//        $article = $articleRepository->findName1();
//        dd($article);

        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article)
    {
        return $this->render('home/show.html.twig', [
            'article' => $article
        ]);
    }


}
