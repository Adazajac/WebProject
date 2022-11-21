<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function search(ArticleRepository $articleRepository, Request $request): Response
    {

        $search = $request->query->get('q');
        if ($search) {
            $article = $articleRepository->search($search);
        } else {
            $article = $articleRepository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article, Request $request)
    {
        
        return $this->render('home/show.html.twig', [
            'article' => $article
        ]);
    }


}
